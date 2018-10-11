<?php

namespace Ar4ibyitsoftce\Brandslider\Module;


use Illuminate\Database\Eloquent\Model;

class Sliders_brand extends Model
{
    use \Themsaid\Multilingual\Translatable;

    protected $fillable = ['path', 'title', 'text', 'url'];
    public $translatable = ['title', 'text'];
    public $casts = [
        'title' => 'array',
        'text' => 'array'
    ];
}