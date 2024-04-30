<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class Admins.
 *
 * @package namespace App\Models;
 */
class Admins extends Authenticatable implements Transformable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    use TransformableTrait;

    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'nickname', 'avatar', 'is_super', 'ip'];


    protected $guarded = [];

    protected $hidden = [
        'password',
    ];
}
