<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class WorkSession
 *
 * @property $id
 * @property $personel_id
 * @property $work_date
 * @property $start_time
 * @property $end_time
 * @property $duration
 * @property $notes
 * @property $status_id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Personel $personel
 * @property WorkStatus $workStatus
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkSession extends Model
{
    private const STANDARD_WORK_MINUTES = 480;

    use SoftDeletes;

    protected $perPage = 20;
    protected $casts = [
        'duration' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['personel_id', 'work_date', 'start_time', 'end_time', 'duration', 'notes', 'status_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personel()
    {
        return $this->belongsTo(\App\Models\Personel::class, 'personel_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workStatus()
    {
        return $this->belongsTo(\App\Models\WorkStatus::class, 'status_id', 'id');
    }

    /**
     * Zwraca zaokrąglony czas pracy zgodnie z zasadami nadgodzin.
     * Po standardowej normie nadgodziny są zaokrąglane w dół do pełnych 15 minut.
     * Uwzględnia regulamin czasu pracy obowiązujący w dniu pracy.
     */
    public function getAdjustedDuration(): int
    {
        if ($this->duration === null) {
            return 0;
        }

        $minutes = max(0, (int) $this->duration);
        
        // Pobierz regulamin czasu pracy obowiązujący w dniu pracy
        $regulation = $this->getApplicableWorkTimeRegulation();
        
        // Jeśli pracownik ma regulamin, użyj go; w przeciwnym razie użyj standardowych 8h
        if ($regulation) {
            return $regulation->getAdjustedDuration($minutes);
        }
        
        // Fallback do standardowych 8h
        $standardWorkMinutes = self::STANDARD_WORK_MINUTES;

        // Jeśli przepracowano standardowy czas lub mniej, zwróć faktyczny czas
        if ($minutes <= $standardWorkMinutes) {
            return $minutes;
        }

        // Oblicz nadgodziny
        $overtimeMinutes = $minutes - $standardWorkMinutes;

        // Zaokrąglij nadgodziny w dół do pełnych 15 minut
        $roundedOvertimeMinutes = (int) (floor($overtimeMinutes / 15) * 15);

        // Zwróć standardowy czas + zaokrąglone nadgodziny
        return $standardWorkMinutes + $roundedOvertimeMinutes;
    }

    public function getDurationHumanAttribute(): ?string
    {
        if ($this->duration === null) {
            return null;
        }

        // Używamy zaokrąglonej wartości dla wyświetlania
        $minutes = $this->getAdjustedDuration();
        $hours = intdiv($minutes, 60);
        $leftover = $minutes % 60;

        if ($hours === 0) {
            return sprintf('%d min', $leftover);
        }

        if ($leftover === 0) {
            return sprintf('%dh', $hours);
        }

        return sprintf('%dh %02dmin', $hours, $leftover);
    }

    public function hasRecordedDuration(): bool
    {
        return $this->duration !== null;
    }

    public function getHasOvertimeAttribute(): bool
    {
        if (!$this->hasRecordedDuration()) {
            return false;
        }
        
        $regulation = $this->getApplicableWorkTimeRegulation();
        
        if ($regulation) {
            // Dla zadaniowego czasu pracy nie ma nadgodzin
            if ($regulation->is_task_based) {
                return false;
            }
            return $this->duration > $regulation->getExpectedDailyMinutes();
        }
        
        return $this->duration > self::STANDARD_WORK_MINUTES;
    }

    public function getIncompleteShiftWarningAttribute(): ?string
    {
        if (! $this->hasRecordedDuration()) {
            return null;
        }

        $regulation = $this->getApplicableWorkTimeRegulation();
        
        // Dla zadaniowego czasu pracy nie ma ostrzeżenia o niepełnym wymiarze
        if ($regulation && $regulation->is_task_based) {
            return null;
        }
        
        $expectedMinutes = $regulation 
            ? $regulation->getExpectedDailyMinutes() 
            : self::STANDARD_WORK_MINUTES;

        return $this->duration < $expectedMinutes
            ? 'Nie przepracował pełnego czasu pracy'
            : null;
    }

    public function getDisplayStatusAttribute(): string
    {
        if ($this->end_time !== null) {
            return 'Obecny (zakończył pracę)';
        }

        return $this->workStatus->name ?? '-';
    }

    /**
     * Pobiera regulamin czasu pracy obowiązujący w dniu pracy
     */
    public function getApplicableWorkTimeRegulation(): ?WorkTimeRegulation
    {
        if (!$this->personel || !$this->work_date) {
            return null;
        }

        return $this->personel->getWorkTimeRegulationOnDate(
            \Carbon\Carbon::parse($this->work_date)
        );
    }

    /**
     * Zwraca oczekiwany czas pracy dla danej sesji na podstawie regulaminu obowiązującego w dniu pracy
     */
    public function getExpectedDuration(): int
    {
        $regulation = $this->getApplicableWorkTimeRegulation();
        
        return $regulation 
            ? $regulation->getExpectedDailyMinutes()
            : self::STANDARD_WORK_MINUTES;
    }

    /**
     * Zwraca informację o regulaminie czasu pracy obowiązującym w dniu pracy
     */
    public function getWorkTimeRegulationInfo(): ?string
    {
        $regulation = $this->getApplicableWorkTimeRegulation();
        
        if (!$regulation) {
            return 'Brak przypisanego regulaminu';
        }

        return $regulation->name;
    }
}
