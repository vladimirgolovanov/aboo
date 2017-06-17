<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostGroup;
use App\Models\Tags\Tag;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use App\Scopes\ArchiveScope;

class WishlistController extends PostController
{
    public function group(PostGroup $postGroup, $type = null)
    {
        if ($type === 'archive') {
            $posts = Post::where('post_group_id', $postGroup->id)
                ->withoutGlobalScopes([ArchiveScope::class])
                ->whereNotNull('archived_at')
                ->get();
        } else {
            $posts = Post::where('post_group_id', $postGroup->id)->get();
        }

        return view('wishlist.index', compact('posts', 'postGroup', 'type'));
    }

    public function tag(PostGroup $postGroup, $tagName)
    {
        $tagName = mb_strtolower($tagName);
        $tag = Tag::where('name', $tagName)->first();

        $posts = Post::join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                     ->where('post_tag.tag_id', $tag->id)
                     ->where('post_tag.post_group_id', $postGroup->id)
                     ->get();

        return view('wishlist.index', compact('posts', 'postGroup', 'tag'));
    }
}
