<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class Admins.
 *
 * @package namespace App\Models;
 */
class Admins extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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


    public function findForPassport($username)
    {
        return $this->orWhere('username', $username)->first(); // ->orWhere('phone', $login)
    }
}
