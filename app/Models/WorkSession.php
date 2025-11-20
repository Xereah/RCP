<?php

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
     * Po 8h nadgodziny są zaokrąglane w dół do pełnych 15 minut.
     */
    public function getAdjustedDuration(): int
    {
        if ($this->duration === null) {
            return 0;
        }

        $minutes = max(0, (int) $this->duration);
        $standardWorkMinutes = 480; // 8 godzin

        // Jeśli przepracowano 8h lub mniej, zwróć faktyczny czas
        if ($minutes <= $standardWorkMinutes) {
            return $minutes;
        }

        // Oblicz nadgodziny
        $overtimeMinutes = $minutes - $standardWorkMinutes;

        // Zaokrąglij nadgodziny w dół do pełnych 15 minut
        $roundedOvertimeMinutes = (int) (floor($overtimeMinutes / 15) * 15);

        // Zwróć 8h + zaokrąglone nadgodziny
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
}
