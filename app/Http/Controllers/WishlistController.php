<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostGroup;
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
}
