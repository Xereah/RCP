<?php

declare(strict_types=1);

namespace App\Livewire\RCP;

use App\Models\Personel;
use App\Models\WorkSession;
use App\Models\WorkStatus;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Index extends Component
{
    private const STATUS_CANDIDATES = [
        'entry' => ['Obecny'],
        'exit' => ['Nieobecny'],
    ];

    public bool $showModal = false;

    public string $mode = 'entry';

    public string $employeeNumber = '';

    public ?string $alertMessage = null;

    public string $alertVariant = 'success';
    public ?Personel $personel = null;

    protected function rules(): array
    {
        return [
            'employeeNumber' => ['required', 'digits_between:4,10', 'exists:personel,personal_number'],
        ];
    }

    public function openModal(string $mode): void
    {
        $this->resetValidation();
        $this->mode = $mode;
        $this->employeeNumber = '';
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset('employeeNumber');
    }

    public function appendDigit(string $digit): void
    {
        if (strlen($this->employeeNumber) >= 10 || !ctype_digit($digit)) {
            return;
        }

        $this->employeeNumber .= $digit;
    }

    public function erase(): void
    {
        $this->employeeNumber = substr($this->employeeNumber, 0, -1);
    }

    public function clear(): void
    {
        $this->employeeNumber = '';
    }

    public function submit(): void
    {
        $this->alertMessage = null;
        $this->alertVariant = 'success';

        $validated = $this->validate();

        $personel = Personel::query()
            ->where('personal_number', $validated['employeeNumber'])
            ->where('is_active', true)
            ->first();

        if (! $personel) {
            throw ValidationException::withMessages([
                'employeeNumber' => 'Pracownik jest nieaktywny lub nie istnieje.',
            ]);
        }

        try {
            $message = $this->mode === 'entry'
                ? $this->handleEntry($personel->id)
                : $this->handleExit($personel->id);

            $this->alertMessage = $message;
            $this->alertVariant = 'success';
            $this->closeModal();
        } catch (ValidationException $exception) {
            $this->alertVariant = 'error';
            $this->alertMessage = $exception->getMessage();
            throw $exception;
        }
    }

    private function handleEntry(int $personelId): string
    {
        $now = now();
        $today = $now->toDateString();

        $activeSession = WorkSession::query()
            ->where('personel_id', $personelId)
            ->whereNull('end_time')
            ->latest('start_time')
            ->first();

        if ($activeSession) {
            throw ValidationException::withMessages([
                'employeeNumber' => 'Istnieje już otwarta sesja. Zarejestruj wyjście.',
            ]);
        }

        // Sprawdź, czy pracownik już dzisiaj rejestrował wejście
        $todayEntryExists = WorkSession::query()
            ->where('personel_id', $personelId)
            ->where('work_date', $today)
            ->whereNotNull('start_time')
            ->exists();

        $personel = Personel::query()
            ->where('id', $personelId)
            ->first();

        if ($todayEntryExists) {
            throw ValidationException::withMessages([
                'employeeNumber' => 'Wejście zostało już zarejestrowane dla tego pracownika w dniu dzisiejszym.',
            ]);
        }

        WorkSession::query()->create([
            'personel_id' => $personelId,
            'work_date' => $today,
            'start_time' => $now->format('H:i:s'),
            'status_id' => $this->resolveStatusId('entry'),
        ]);

        return 'Witaj ' . $personel->first_name . ' ' . $personel->last_name . '! Wejście zostało zapisane. Miłego dnia!';
    }

    private function handleExit(int $personelId): string
    {
        $session = WorkSession::query()
            ->where('personel_id', $personelId)
            ->whereNull('end_time')
            ->latest('start_time')
            ->first();

        if (! $session) {
            throw ValidationException::withMessages([
                'employeeNumber' => 'Brak aktywnej sesji do zamknięcia.',
            ]);
        }

        $personel = Personel::query()
        ->where('id', $personelId)
        ->first();

        $now = now();
        $today = $now->toDateString();

        // Sprawdź, czy pracownik już dzisiaj rejestrował wyjście
        $todayExitExists = WorkSession::query()
            ->where('personel_id', $personelId)
            ->where('work_date', $today)
            ->whereNotNull('end_time')
            ->exists();

        if ($todayExitExists) {
            throw ValidationException::withMessages([
                'employeeNumber' => 'Wyjście dla ' . $personel->first_name . ' ' . $personel->last_name . ' zostało już zarejestrowane w dniu dzisiejszym.',
            ]);
        }    

        $start = Carbon::parse("{$session->work_date} {$session->start_time}");
        $durationMinutes = $start->diffInMinutes($now);

        // Oblicz czas trwania z zaokrągleniem nadgodzin
        $adjustedDuration = $this->calculateAdjustedDuration($durationMinutes);

        $session->update([
            'end_time' => $now->format('H:i:s'),
            'duration' => $adjustedDuration,
            'status_id' => $this->resolveStatusId('exit'),
        ]);

        return 'Dziękujemy za pracę ' . $personel->first_name . ' ' . $personel->last_name . '! Wyjście zostało zapisane. Do zobaczenia!';
    }

    /**
     * Oblicza skorygowany czas pracy z zaokrągleniem nadgodzin.
     * Po 8h (480 min) nadgodziny zaokrąglane są w dół do pełnych 15 minut.
     */
    private function calculateAdjustedDuration(int|float $durationMinutes): int
    {
        $durationMinutes = (int) floor($durationMinutes);
    
        $standardWorkMinutes = 480;
    
        if ($durationMinutes <= $standardWorkMinutes) {
            return $durationMinutes;
        }
    
        $overtimeMinutes = $durationMinutes - $standardWorkMinutes;
    
        $roundedOvertimeMinutes = (int) (floor($overtimeMinutes / 15) * 15);
    
        return $standardWorkMinutes + $roundedOvertimeMinutes;
    }
    

    private function resolveStatusId(string $phase): int
    {
        $names = self::STATUS_CANDIDATES[$phase] ?? [];

        foreach ($names as $name) {
            $id = WorkStatus::query()
                ->where('name', $name)
                ->value('id');

            if ($id) {
                return (int) $id;
            }
        }

        $fallback = WorkStatus::query()->orderBy('id')->value('id');

        if (! $fallback) {
            throw ValidationException::withMessages([
                'employeeNumber' => 'Brak skonfigurowanych statusów pracy. Skontaktuj się z administratorem.',
            ]);
        }

        return (int) $fallback;
    }

    public function render()
    {
        return view('livewire.r-c-p.index');
    }
}
