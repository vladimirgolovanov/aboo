<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = true;

    protected $fillable = [
        'post_group_id',
        'text',
        'text_parsed',
    ];

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function postGroup()
    {
        return $this->belongsTo('App\PostGroup');
    }
}
