<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class PersonelWorkTimeRegulationHistory
 *
 * @property $id
 * @property $personel_id
 * @property $work_time_regulation_id
 * @property $valid_from
 * @property $valid_to
 * @property $notes
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Personel $personel
 * @property WorkTimeRegulation $workTimeRegulation
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PersonelWorkTimeRegulationHistory extends Model
{
    use SoftDeletes;

    protected $table = 'personel_work_time_regulation_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'personel_id',
        'work_time_regulation_id',
        'valid_from',
        'valid_to',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
        'is_active' => 'boolean',
    ];

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
    public function workTimeRegulation()
    {
        return $this->belongsTo(\App\Models\WorkTimeRegulation::class, 'work_time_regulation_id', 'id');
    }

    /**
     * Sprawdza czy regulamin jest aktualnie obowiązujący
     */
    public function isCurrentlyValid(): bool
    {
        $today = Carbon::today();
        
        return $this->is_active 
            && $today->greaterThanOrEqualTo($this->valid_from)
            && ($this->valid_to === null || $today->lessThanOrEqualTo($this->valid_to));
    }

    /**
     * Sprawdza czy regulamin obowiązywał w danym dniu
     */
    public function isValidOnDate(Carbon $date): bool
    {
        return $this->is_active
            && $date->greaterThanOrEqualTo($this->valid_from)
            && ($this->valid_to === null || $date->lessThanOrEqualTo($this->valid_to));
    }

    /**
     * Scope do pobrania aktualnie obowiązujących regulaminów
     */
    public function scopeCurrentlyValid($query)
    {
        $today = Carbon::today();
        
        return $query->where('is_active', true)
            ->where('valid_from', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('valid_to')
                  ->orWhere('valid_to', '>=', $today);
            });
    }

    /**
     * Scope do pobrania regulaminu obowiązującego w danym dniu
     */
    public function scopeValidOnDate($query, Carbon $date)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('valid_to')
                  ->orWhere('valid_to', '>=', $date);
            });
    }

    /**
     * Zwraca liczbę dni do końca obowiązywania regulaminu
     */
    public function getDaysUntilExpiration(): ?int
    {
        if ($this->valid_to === null) {
            return null; // Bezterminowy
        }

        return Carbon::today()->diffInDays($this->valid_to, false);
    }

    /**
     * Sprawdza czy regulamin wkrótce wygasa (domyślnie 30 dni)
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        $daysUntilExpiration = $this->getDaysUntilExpiration();
        
        return $daysUntilExpiration !== null 
            && $daysUntilExpiration > 0 
            && $daysUntilExpiration <= $days;
    }

    /**
     * Zwraca czas trwania regulaminu
     */
    public function getDurationAttribute(): string
    {
        $from = $this->valid_from->format('d.m.Y');
        $to = $this->valid_to ? $this->valid_to->format('d.m.Y') : 'obecnie';
        
        return "{$from} - {$to}";
    }
}

