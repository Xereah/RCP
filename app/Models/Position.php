<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Position
 *
 * @property $id
 * @property $created_at
 * @property $updated_at
 *
 * @property PersonalDatum[] $personalDatas
 * @property Personel[] $personels
 * @property PersonalDatum[] $personalDatas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Position extends Model
{

    protected $table = 'position';
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
    public function personalDatas()
    {
        return $this->hasMany(\App\Models\PersonalDatum::class, 'id', 'stanowisko');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personels()
    {
        return $this->hasMany(\App\Models\Personel::class, 'id', 'position_id');
    }
    
}
