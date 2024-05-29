<?php

namespace App\Models;

class CollectiveLog extends BaseModel
{

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->withTrashed();
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'collective_id', 'id')->withTrashed();
    }
}
