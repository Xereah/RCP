<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class WorkTimeRegulation
 *
 * @property $id
 * @property $name
 * @property $code
 * @property $description
 * @property $daily_hours
 * @property $weekly_hours
 * @property $monthly_hours
 * @property $is_task_based
 * @property $break_minutes
 * @property $nursing_mother_break
 * @property $start_time_flex
 * @property $end_time_flex
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Personel[] $personels
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkTimeRegulation extends Model
{
    use SoftDeletes;

    protected $table = 'work_time_regulations';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'daily_hours',
        'weekly_hours',
        'monthly_hours',
        'is_task_based',
        'break_minutes',
        'nursing_mother_break',
        'start_time_flex',
        'end_time_flex',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'daily_hours' => 'decimal:2',
        'weekly_hours' => 'decimal:2',
        'monthly_hours' => 'decimal:2',
        'is_task_based' => 'boolean',
        'break_minutes' => 'integer',
        'nursing_mother_break' => 'integer',
        'start_time_flex' => 'integer',
        'end_time_flex' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personels()
    {
        return $this->hasMany(\App\Models\Personel::class, 'work_time_regulation_id', 'id');
    }

    /**
     * Oblicza oczekiwany czas pracy w minutach dla danego dnia
     */
    public function getExpectedDailyMinutes(): int
    {
        if ($this->is_task_based) {
            return 0; // Dla zadaniowego czasu pracy nie ma sztywnego wymiaru
        }

        return (int) ($this->daily_hours * 60);
    }

    /**
     * Oblicza oczekiwany tygodniowy czas pracy w minutach
     */
    public function getExpectedWeeklyMinutes(): int
    {
        return (int) ($this->weekly_hours * 60);
    }

    /**
     * Oblicza oczekiwany miesięczny czas pracy w minutach
     */
    public function getExpectedMonthlyMinutes(): int
    {
        return (int) ($this->monthly_hours * 60);
    }

    /**
     * Sprawdza czy dana sesja jest nadgodzinami
     */
    public function isOvertime(int $durationMinutes): bool
    {
        if ($this->is_task_based) {
            return false;
        }

        return $durationMinutes > $this->getExpectedDailyMinutes();
    }

    /**
     * Oblicza skorygowany czas pracy uwzględniając regulamin
     */
    public function getAdjustedDuration(int $durationMinutes): int
    {
        if ($this->is_task_based || $durationMinutes === 0) {
            return $durationMinutes;
        }

        $standardWorkMinutes = $this->getExpectedDailyMinutes();

        // Jeśli przepracowano standardowy czas lub mniej, zwróć faktyczny czas
        if ($durationMinutes <= $standardWorkMinutes) {
            return $durationMinutes;
        }

        // Oblicz nadgodziny
        $overtimeMinutes = $durationMinutes - $standardWorkMinutes;

        // Zaokrąglij nadgodziny w dół do pełnych 15 minut
        $roundedOvertimeMinutes = (int) (floor($overtimeMinutes / 15) * 15);

        // Zwróć standardowy czas + zaokrąglone nadgodziny
        return $standardWorkMinutes + $roundedOvertimeMinutes;
    }

    /**
     * Zwraca informację o elastycznych godzinach rozpoczęcia
     */
    public function hasFlexibleStartTime(): bool
    {
        return $this->start_time_flex > 0;
    }

    /**
     * Zwraca informację o elastycznych godzinach zakończenia
     */
    public function hasFlexibleEndTime(): bool
    {
        return $this->end_time_flex > 0;
    }

    /**
     * Zwraca pełny opis regulaminu
     */
    public function getFullDescriptionAttribute(): string
    {
        $parts = [];

        if ($this->is_task_based) {
            $parts[] = 'Zadaniowy czas pracy';
        } else {
            $parts[] = sprintf('%.1fh dziennie', $this->daily_hours);
            $parts[] = sprintf('%.1fh tygodniowo', $this->weekly_hours);
        }

        if ($this->nursing_mother_break > 0) {
            $parts[] = sprintf('Przerwa dla matki karmiącej: %d min', $this->nursing_mother_break);
        }

        if ($this->hasFlexibleStartTime()) {
            $parts[] = sprintf('Elastyczny start: ±%d min', $this->start_time_flex);
        }

        return implode(', ', $parts);
    }
}

