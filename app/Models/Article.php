<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'belong_id',
        'pid',
        'name',
        'type',
        'content',
        'click',
    ];

    public $appends = [
        'class_name'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function class()
    {
        return $this->hasOne(ArticleMenu::class, 'id', 'pid');
    }

    public function getClassNameAttribute()
    {
        return $this->class->name ?? '';
    }
}
