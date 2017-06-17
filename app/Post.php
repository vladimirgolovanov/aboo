<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ArchiveScope;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = true;

    protected $fillable = [
        'post_group_id',
        'text',
        'text_parsed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ArchiveScope);
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tags\Tag');
    }

    public function postGroup()
    {
        return $this->belongsTo('App\PostGroup');
    }
}
