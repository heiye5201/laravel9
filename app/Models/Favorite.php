<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use HasFactory;

    use SoftDeletes, TimeTrait;

    protected $guarded = [];

    public function goods()
    {
        return $this->hasOne('App\Models\Goods', 'id', 'out_id')->withTrashed();
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'out_id')->withTrashed();
    }
}
