<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostGroup extends Model
{
    protected $table = 'post_groups';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

    public function postGroupType()
    {
        return $this->belongsTo('App\PostGroupType', 'id', 'post_group_type_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'post_id', 'id');
    }
}
