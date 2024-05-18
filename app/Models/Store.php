<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $guarded = [];

//    protected $fillable = [
//        'store_name',
//        'store_logo',
//        'store_face_image',
//        'store_slide'
//    ];

    protected $hidden = [
        'deleted_at',
    ];

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
