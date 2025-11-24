<?php

declare(strict_types=1);

namespace App\Livewire\Personels;

use App\Models\Personel;
use App\Models\WorkSession;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class TimeReport extends Component
{
    public ?string $personalNumber = null;
    public ?string $password = null;
    public bool $isAuthenticated = false;
    public ?Personel $personel = null;
    
    public int $currentYear;
    public int $currentMonth;
    
    public bool $showAuthModal = true;
    
    public function mount(): void
    {
        // Ustaw aktualny miesiąc i rok
        $this->currentYear = Carbon::now()->year;
        $this->currentMonth = Carbon::now()->month;
    }
    
    public function previousMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
    }
    
    public function nextMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
    }
    
    public function goToCurrentMonth(): void
    {
        $this->currentYear = Carbon::now()->year;
        $this->currentMonth = Carbon::now()->month;
    }
    
    public function authenticate(): void
    {
        $this->validate([
            'personalNumber' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'personalNumber.required' => 'Numer pracownika jest wymagany',
            'password.required' => 'Hasło jest wymagane',
        ], [
            'personalNumber' => 'numer pracownika',
            'password' => 'hasło',
        ]);
        
        // Znajdź pracownika po numerze personalnym
        $personel = Personel::where('personal_number', $this->personalNumber)
            ->where('is_active', true)
            ->first();
            
        if (!$personel) {
            $this->addError('personalNumber', 'Nie znaleziono aktywnego pracownika o podanym numerze');
            return;
        }
        
        // Sprawdź hasło (numer personalny z zerem na początku)
        $expectedPassword = '0' . $this->personalNumber;
        
        if ($this->password !== $expectedPassword) {
            $this->addError('password', 'Nieprawidłowe hasło');
            return;
        }
        
        // Autoryzacja udana
        $this->isAuthenticated = true;
        $this->personel = $personel;
        $this->showAuthModal = false;
        $this->reset('password');
    }
    
    public function logout(): void
    {
        $this->isAuthenticated = false;
        $this->personel = null;
        $this->showAuthModal = true;
        $this->reset('personalNumber', 'password');
    }
    
    public function render(): View
    {
        $workSessions = collect();
        $todayMinutes = 0;
        $monthMinutes = 0;
        $calendarDays = [];
        
        if ($this->isAuthenticated && $this->personel) {
            // Pobierz sesje pracy dla wybranego miesiąca
            $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
            $endDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();
            
            $workSessions = WorkSession::query()
                ->where('personel_id', $this->personel->id)
                ->whereBetween('work_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->orderBy('work_date')
                ->orderBy('start_time')
                ->with(['workStatus'])
                ->get();
            
            // Oblicz czas pracy dla dzisiaj
            $todayMinutes = WorkSession::query()
                ->where('personel_id', $this->personel->id)
                ->whereDate('work_date', Carbon::today())
                ->get()
                ->sum(fn($session) => $session->getAdjustedDuration());
            
            // Oblicz czas w wybranym miesiącu
            $monthMinutes = $workSessions->sum(fn($session) => $session->getAdjustedDuration());
            
            // Przygotuj dane kalendarza
            $calendarDays = $this->prepareCalendarDays($startDate, $endDate, $workSessions);
        }
        
        return view('livewire.personel.time-report', [
            'workSessions' => $workSessions,
            'todayMinutes' => $todayMinutes,
            'monthMinutes' => $monthMinutes,
            'calendarDays' => $calendarDays,
        ]);
    }
    
    private function prepareCalendarDays(Carbon $startDate, Carbon $endDate, Collection $workSessions): array
    {
        $days = [];
        $current = $startDate->copy();
        
        // Grupuj sesje według daty
        $sessionsByDate = $workSessions->groupBy(function ($session) {
            return Carbon::parse($session->work_date)->format('Y-m-d');
        });
        
        while ($current <= $endDate) {
            $dateKey = $current->format('Y-m-d');
            $sessions = $sessionsByDate->get($dateKey, collect());
            $holiday = $this->getHoliday($current);
            
            $days[] = [
                'date' => $current->copy(),
                'dayNumber' => $current->day,
                'dayName' => $current->locale('pl')->shortDayName,
                'isWeekend' => $current->isWeekend(),
                'isToday' => $current->isToday(),
                'isHoliday' => $holiday !== null,
                'holidayName' => $holiday,
                'sessions' => $sessions,
                'totalMinutes' => $sessions->sum(fn($session) => $session->getAdjustedDuration()),
            ];
            
            $current->addDay();
        }
        
        return $days;
    }
    
    private function getHoliday(Carbon $date): ?string
    {
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;
        
        // Święta stałe
        $fixedHolidays = [
            '01-01' => 'Nowy Rok',
            '01-06' => 'Święto Trzech Króli',
            '05-01' => 'Święto Pracy',
            '05-03' => 'Święto Konstytucji 3 Maja',
            '08-15' => 'Wniebowzięcie NMP',
            '11-01' => 'Wszystkich Świętych',
            '11-11' => 'Święto Niepodległości',
            '12-25' => 'Boże Narodzenie (I dzień)',
            '12-26' => 'Boże Narodzenie (II dzień)',
        ];
        
        $dateKey = sprintf('%02d-%02d', $month, $day);
        if (isset($fixedHolidays[$dateKey])) {
            return $fixedHolidays[$dateKey];
        }
        
        // Święta ruchome (Wielkanoc i związane z nią)
        $easter = $this->getEasterDate($year);
        
        // Wielkanoc
        if ($date->isSameDay($easter)) {
            return 'Wielkanoc';
        }
        
        // Poniedziałek Wielkanocny
        if ($date->isSameDay($easter->copy()->addDay())) {
            return 'Poniedziałek Wielkanocny';
        }
        
        // Boże Ciało (60 dni po Wielkanocy)
        if ($date->isSameDay($easter->copy()->addDays(60))) {
            return 'Boże Ciało';
        }
        
        // Zielone Świątki (50 dni po Wielkanocy)
        if ($date->isSameDay($easter->copy()->addDays(49))) {
            return 'Zielone Świątki';
        }
        
        return null;
    }
    
    private function getEasterDate(int $year): Carbon
    {
        // Algorytm Gaussa do obliczania daty Wielkanocy
        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;
        
        return Carbon::create($year, $month, $day);
    }
    
    private function formatMinutes(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;
        
        if ($mins === 0) {
            return sprintf('%dh', $hours);
        }
        
        return sprintf('%dh %02dmin', $hours, $mins);
    }
}

