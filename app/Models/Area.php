<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;


    protected $fillable = [
        'pid',
        'name',
        'code',
        'deep',
    ];


    protected $hidden = [
        'deleted_at',
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
