<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostGroup;
use App\Models\Tags\Tag;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;

class WishlistController extends PostController
{
    public function group(PostGroup $postGroup)
    {
        $posts = Post::where('post_group_id', $postGroup->id)
            ->get();

        return view('wishlist.index', ['posts' => $posts, 'postGroup' => $postGroup]);
    }

    public function tag(PostGroup $postGroup, $tagName)
    {
        $tagName = mb_strtolower($tagName);
        $tag = Tag::where('name', $tagName)->first();

        $posts = Post::join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                     ->where('post_tag.tag_id', $tag->id)
                     ->where('post_tag.post_group_id', $postGroup->id)
                     ->get();

        return view('wishlist.index', ['posts' => $posts, 'postGroup' => $postGroup, 'tag' => $tag]);
    }
}
