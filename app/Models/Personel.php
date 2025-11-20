<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Personel
 *
 * @property $id
 * @property $personal_number
 * @property $last_name
 * @property $first_name
 * @property $email
 * @property $position_id
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Position $position
 * @property WorkSession[] $workSessions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Personel extends Model
{
    use SoftDeletes;

    protected $table = 'personel';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['personal_number', 'last_name', 'first_name', 'email', 'position_id', 'is_active'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class, 'position_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workSessions()
    {
        return $this->hasMany(\App\Models\WorkSession::class, 'id', 'personel_id');
    }
    
}
