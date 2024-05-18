<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectiveLog extends Model
{
    use HasFactory;

    use SoftDeletes, TimeTrait;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->withTrashed();
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'collective_id', 'id')->withTrashed();
    }
}
