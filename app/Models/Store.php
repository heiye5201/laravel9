<?php

namespace App\Models;

class Store extends BaseModel
{

//    protected $fillable = [
//        'store_name',
//        'store_logo',
//        'store_face_image',
//        'store_slide'
//    ];

    public function storeClasses()
    {
        return $this->hasOne('App\Models\StoreClass', 'store_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\OrderComment', 'store_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'store_id', 'id');
    }
}
