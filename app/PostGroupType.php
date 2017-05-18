<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostGroupType extends Model
{
    protected $table = 'post_group_types';
    public $timestamps = false;

    public function postGroups()
    {
        return $this->hasMany('App\PostGroup', 'post_group_type_id', 'id');
    }
}
