<?php

namespace App\Models;

class Area extends BaseModel
{

    protected $fillable = [
        'pid',
        'name',
        'code',
        'deep',
    ];

    public function hasChildren()
    {
        return $this->hasOne(Area::class, 'pid', 'code');
    }


    public function region()
    {
        return $this->hasMany(Area::class, 'pid', 'code');
    }

    public function city()
    {
        return $this->hasMany(Area::class, 'pid', 'code')
            ->with(['region']);
    }
}
