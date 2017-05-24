<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostGroup extends Model
{
    protected $table = 'post_groups';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'post_group_type_id',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

    public function postGroupType()
    {
        return $this->belongsTo('App\PostGroupType');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
