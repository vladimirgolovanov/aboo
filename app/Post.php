<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = true;

    public function postGroup()
    {
        return $this->belongsTo('App\PostGroup', 'id', 'post_group_id');
    }
}
