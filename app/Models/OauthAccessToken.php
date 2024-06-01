<?php
/**
 * autor      : jiweijian
 * createTime : 2024/6/1 12:00
 * description:
 */
namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    use HasFactory;

    use TimeTrait;

    protected $guarded = [];
}
