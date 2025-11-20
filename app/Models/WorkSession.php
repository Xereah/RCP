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
    
}
