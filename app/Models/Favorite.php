<?php

namespace App\Models;

class Favorite extends BaseModel
{
    public function goods()
    {
        return $this->hasOne('App\Models\Goods', 'id', 'out_id')->withTrashed();
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'out_id')->withTrashed();
    }
}
