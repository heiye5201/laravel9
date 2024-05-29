<?php

namespace App\Models;

class CouponLog extends BaseModel
{

    protected $dates = ['start_time','end_time'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->withTrashed();
    }
}
