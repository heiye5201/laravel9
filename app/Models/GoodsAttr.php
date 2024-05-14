<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsAttr extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'store_id',
        'name',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function specs()
    {
        return $this->hasMany('App\Models\GoodsSpecs', 'attr_id', 'id');
    }
}
