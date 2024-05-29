<?php

namespace App\Models;

class GoodsSpecs extends BaseModel
{

    protected $fillable = [
        'attr_id',
        'name',
    ];

    public function attrs()
    {
        return $this->hasOne('App\Models\GoodsAttr', 'id', 'attr_id');
    }
}
