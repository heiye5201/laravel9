<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributionLog extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
    ];

    public function order_goods()
    {
        return $this->hasOne('App\Models\OrderGoods', 'id', 'order_goods_id')->withTrashed();
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->withTrashed();
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'store_id')->withTrashed();
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id')->withTrashed();
    }
}
