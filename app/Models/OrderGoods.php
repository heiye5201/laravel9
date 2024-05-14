<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderGoods extends Model
{
    use HasFactory;

    use SoftDeletes, TimeTrait;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
    ];

    public function distribution()
    {
        return $this->hasOne("App\Models\Distribution", "goods_id", 'goods_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", 'user_id');
    }
}
