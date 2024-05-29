<?php

namespace App\Models;

class Article extends BaseModel
{

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

    public function class()
    {
        return $this->hasOne(ArticleMenu::class, 'id', 'pid');
    }

    public function getClassNameAttribute()
    {
        return $this->class->name ?? '';
    }
}
