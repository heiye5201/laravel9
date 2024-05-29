<?php

namespace App\Models;

class SmsLog extends BaseModel
{

    protected $fillable = [
        'phone',
        'name',
        'content',
        'status',
        'error_msg',
        'ip',
    ];
}
