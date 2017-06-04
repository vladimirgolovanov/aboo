<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
