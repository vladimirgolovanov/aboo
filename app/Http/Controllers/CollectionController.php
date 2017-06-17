<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostGroup;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;

class CollectionController extends PostController
{
    /**
     * @todo: Post::getGroupPosts(PostGroup $postGroup, $type)
     */
    public function group(PostGroup $postGroup, $type = null)
    {
        if ($type) {
            $posts = Post::where('post_group_id', $postGroup->id)
                ->withoutGlobalScopes([ArchiveScope::class])
                ->whereNotNull('archived_at')
                ->get();
        } else {
            $posts = Post::where('post_group_id', $postGroup->id)
                ->get();
        }

        return view('collection.index', compact('posts', 'postGroup', 'type'));
    }
}
