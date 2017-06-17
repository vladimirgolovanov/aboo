<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostGroup;
use App\PostGroupType;
use App\Image;
use App\User;
use App\Models\Tags\Tag;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use HashTagger\HashTagger;

class PostController extends Controller
{
    /**
     * @todo: post_groups.id as post_group_id
     */
    public function index()
    {
        $postGroupTypes = PostGroupType::select('post_groups.id as id', 'post_group_types.name as name', 'post_group_types.id as post_group_type_id')
                                       ->leftJoin('post_groups', 'post_group_types.id', '=', 'post_groups.post_group_type_id')
                                       ->where('post_groups.user_id', Auth::id())
                                       ->orWhereNull('post_groups.user_id')
                                       ->get();

        $posts = Post::whereIn('post_group_id', $postGroupTypes->pluck('id')->toArray())
                     ->get();
        $groupedPosts = $posts->groupBy('post_group_id');

        foreach ($postGroupTypes as $postGroupType) {
            if ($postGroupType->id and array_get($groupedPosts, $postGroupType->id)) {
                $groupedPosts[$postGroupType->id] = $groupedPosts[$postGroupType->id]
                    ->filter(function ($post) {
                        return object_get($post->images->first(), 'path');
                    })
                    ->sortByDesc('created_at')
                    ->take(5);
            }
        }

        return view('post.index', ['postGroupTypes' => $postGroupTypes, 'groupedPosts' => $groupedPosts]);
    }

    public function userpage($username)
    {
        if (!$username) {
            return false; // add exception
        }

        $user = User::where('username', $username)->first();

        $postGroupTypes = PostGroupType::select('post_groups.id as id', 'post_group_types.name as name', 'post_group_types.id as post_group_type_id')
                                       ->leftJoin('post_groups', 'post_group_types.id', '=', 'post_groups.post_group_type_id')
                                       ->where('post_groups.user_id', $user->id)
                                       ->orWhereNull('post_groups.user_id')
                                       ->get();

        $posts = Post::whereIn('post_group_id', $postGroupTypes->pluck('id')->toArray())
                     ->get();
        $groupedPosts = $posts->groupBy('post_group_id');

        foreach ($postGroupTypes as $postGroupType) {
            if ($postGroupType->id and array_get($groupedPosts, $postGroupType->id)) {
                $groupedPosts[$postGroupType->id] = $groupedPosts[$postGroupType->id]
                    ->filter(function ($post) {
                        return object_get($post->images->first(), 'path');
                    })
                    ->sortByDesc('created_at')
                    ->take(5);
            }
        }

        return view('userpage.index', compact('postGroupTypes', 'groupedPosts', 'user'));
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

        return redirect()->route('post.create', ['postGroup' => $postGroup]);
    }

    public function create(PostGroup $postGroup)
    {
        $userId = Auth::id();

        $post = new Post;
        $post->post_group_id = $postGroup->id;
        $post->save();

        return redirect()->route('post.show', ['post' => $post]);
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
        $postImages = $post->images()->get();

        $user = Auth::user();

        if ($user and $user->can('edit', $post)) {
            return view('post.item', ['post' => $post, 'postImages' => $postImages]);
        } else {
            return view('post.show', ['post' => $post, 'postImages' => $postImages]);
        }
    }

    public function update(Request $request, Post $post)
    {
        $input = $request->all();

        $post->text = $input['text'];
        $post->text_parsed = nl2br($input['text']);
        $post->save();

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('images/post/'.Auth::id().'/'.$post->id);

            $image = new Image;
            $image->path = $imagePath;
            $image->post_id = $post->id;
            $image->save();
        }

        return response()->json([
            'success' => 'success'
        ]);
    }

    public function uploadImage(Request $request)
    {
        $input = $request->all();
        $postId = $input['post_id'];

        if (!$postId) {
            return false; // add exception
        }

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('images/post/'.Auth::id().'/'.$postId);

            $image = new Image;
            $image->path = $imagePath;
            $image->post_id = $postId;
            $image->save();
        }

        return json_encode([
            'id' => $image->id,
            'path' => $image->path,
            'destroy_image_route' => route('post.destroy_image', ['image' => $image->id]),
        ]);
    }

    public function saveText(Request $request)
    {
        $input = $request->all();
        $postId = $input['post_id'];
        $text = $input['text'];

        if (!$postId) {
            return false; // add exception
        }

        $post = Post::find($postId);
        $post->text = $input['text'];
        $tagger = new HashTagger($post->text);
        // todo: move href out of here
        $post->text_parsed = $tagger->wrap_tags("a", [
            "href" => "/wishlist/".$post->post_group_id."/tag/{tag}",
            "class" => "hashtag"
        ]);
        $post->text_parsed = nl2br($post->text_parsed);
        $post->save();

        $post->tags()->detach();

        foreach ($tagger->get_tags() as $tagName) {
            // todo: prepare tag is better in hashtags class
            $tagName = mb_strtolower($tagName);
            $tagName = mb_substr($tagName, 1);
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $post->tags()->attach($tag, ['post_group_id' => $post->post_group_id]);
        }

        return response()->json([
            'success' => 'success'
        ]);
    }

    public function destroy(Post $post)
    {
        //
    }

    /**
     * @todo: make Route::delete
     */
    public function destroyImage(Image $image)
    {
        if (Storage::exists($image->path)) {
            Storage::delete($image->path);
        }

        $image->delete();

        return response()->json([
            'success' => 'success'
        ]);
    }

    public function archivePost(Post $post)
    {
        if (!$post->archived_at) {
            $post->archived_at = DB::raw('NOW()');
            $post->save();
        }

        return response()->json([
            'success' => 'success'
        ]);
    }
}
