@extends('layouts.master')

@section('title'){{ $post->text }}@endsection

@section('meta')
<meta property="og:title" content="{{ $post->text }}">
@if(object_get($post->images->first(), 'path'))
<meta property="og:image" content="<?= \Storage::url($post->images->first()->path) ?>">
@endif
<meta property="og:url" content="{{ route('post.show', ['post' => $post->id]) }}">
<meta property="og:site_name" content="aboo">
@endsection

@section('header')
    <p><a href="{{ route('collection', ['postGroup' => $post->post_group_id]) }}">Back to Collection</a></p>
    <h1></h1>
@endsection

@section('content')
<form
    class="itemForm"
    method="POST"
    enctype="multipart/form-data"
    action="{{ route('post.update', ['post' => $post->id]) }}"
>
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <input type="hidden" name="post_id" value="{{ $post->id }}">

    {{ $errors->has('text') ? 'has-error' : '' }}
    <textarea
        class="itemFormText js-editable_text"
        name="text"
        rows="5"
        placeholder="Description"
    >{{ $post->text }}</textarea>
    @if ($errors->has('text'))
        {{ $errors->first('text') }}
    @endif

    <div class="editImages js-image_items">
        @foreach($postImages as $postImage)
            <div class="editImage js-image_item">
                <div class="editImageImg" style="background-image: url(/storage/{{ $postImage->path }});">
                    <!-- <img src="/storage/{{ $postImage->path }}"> -->
                </div>
                <span class="deleteImage js-image_item_delete" data-route="{{ route('post.destroy_image', ['image' => $postImage]) }}">
                    remove
                </span>
            </div>
        @endforeach
        <div class="itemImageInputDiv js-image_item_add_div">
            {{ $errors->has('image') ? 'has-error' : '' }}
            <label for="image" class="itemImageInputLabel"><span>Add image</span></label>
            <input id="image" class="itemImageInput js-image_item_add" type="file" name="image">
            @if ($errors->has('image'))
                {{ $errors->first('image') }}
            @endif
        </div></div>

</form>

@endsection
