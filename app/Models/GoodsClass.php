<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsClass extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'pid',
        'thumb',
        'name',
        'simple_name',
        'is_sort'
    ];

    protected $hidden = [
        'deleted_at',
    ];


    public function hasChildren()
    {
        return $this->hasOne('App\Models\GoodsClass', 'pid', 'id');
    }


    public function children()
    {
        return $this->hasMany('App\Models\GoodsClass', 'pid', 'id');
    }
}
