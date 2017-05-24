<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostGroup;
use App\PostGroupType;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    /**
     * @todo: post_groups.id as post_group_id
     */
    public function index()
    {
        $postGroupTypes = PostGroupType::select('post_groups.id', 'post_group_types.name')
                                       ->leftJoin('post_groups', 'post_group_types.id', '=', 'post_groups.post_group_type_id')
                                       ->where('post_groups.user_id', Auth::id())
                                       ->orWhereNull('post_groups.user_id')
                                       ->get();

        $posts = Post::whereIn('post_group_id', $postGroupTypes->pluck('id')->toArray())
                     ->get();
        $groupedPosts = $posts->groupBy('post_group_id');

        foreach ($postGroupTypes as $postGroupType) {
            echo '<hr>';
            echo $postGroupType->name;
            echo '<br>';
            if (!$postGroupType->id) {
                echo '<a href="'.route('post.create_post_group', ['postGroupType' => $postGroupType->id]).'">create group</a>';
                echo '<br>';
            } else {
                foreach ($groupedPosts[$postGroupType->id] as $post) {
                    echo $post->text_parsed;
                    echo ' ';
                    echo '<a href="'.route('post.edit', ['post' => $post->id]).'">edit</a>';
                    echo '<br>';
                }
                echo '<a href="'.route('post.create', ['postGroup' => $postGroupType->id]).'">add item</a>';
                echo '<br>';
            }
        }
    }

    /**
     * Create postGroup before see post/create page
     */
    public function createPostGroup(PostGroupType $postGroupType)
    {
        $postGroup = PostGroup::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'post_group_type_id' => $postGroupType->id,
            ]
        );

        return redirect()->route('post/create', ['postGroup' => $postGroup]);
    }

    public function create(PostGroup $postGroup)
    {
        $userId = Auth::id();

        return view('post.collection.create', ['postGroup' => $postGroup]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $post = new Post;
        $post->text = $input['text'];
        $post->text_parsed = nl2br($input['text']);
        $post->post_group_id = $input['post_group_id'];
        $post->save();

        return response()->json([
            'success' => 'success'
        ]);
    }

    public function show(Post $post)
    {
        echo route('post.edit', ['post' => $post->id]);
    }

    public function edit(Post $post)
    {
        return view('post.collection.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $input = $request->all();

        $post->text = $input['text'];
        $post->text_parsed = nl2br($input['text']);
        $post->save();

        return response()->json([
            'success' => 'success'
        ]);
    }

    public function destroy(Post $post)
    {
        //
    }
}
