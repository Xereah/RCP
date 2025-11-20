<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkStatus
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 *
 * @property WorkSession[] $workSessions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkStatus extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workSessions()
    {
        return $this->hasMany(\App\Models\WorkSession::class, 'id', 'status_id');
    }
    
}
