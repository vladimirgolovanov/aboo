<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    public $timestamps = true;

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
