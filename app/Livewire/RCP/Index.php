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

        WorkSession::query()->create([
            'personel_id' => $personelId,
            'work_date' => $now->toDateString(),
            'start_time' => $now->format('H:i:s'),
            'status_id' => $this->resolveStatusId('entry'),
        ]);

        return 'Wejście zostało zapisane. Miłego dnia!';
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

        $now = now();
        $start = Carbon::parse("{$session->work_date} {$session->start_time}");

        $session->update([
            'end_time' => $now->format('H:i:s'),
            'duration' => $start->diffInMinutes($now),
            'status_id' => $this->resolveStatusId('exit'),
        ]);

        return 'Wyjście zostało zapisane. Do zobaczenia!';
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
