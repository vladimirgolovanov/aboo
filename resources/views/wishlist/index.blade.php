@extends('layouts.master')

@section('header')
    @if(!empty($tag))
            <a href="{{ route('wishlist', ['postGroup' => $postGroup]) }}">{{ $postGroup->name }}</a>
            #{{ $tag->name }}
        </h1>
    @else
        <h1>{{ $postGroup->name or 'Wishlist' }}</h1>
        @can('edit', $postGroup)
        {{ csrf_field() }}
        <input type="hidden" name="post_group_id" value="{{ $postGroup->id }}">
        <div class="editHeaderInput js-edit_header_input">
            <input type="text" name="name" value="{{ $postGroup->name or 'Wishlist' }}">
        </div>
        <div class="editHeader js-edit_header_icon"></div>
        @endcan
    @endif
@endsection

@section('controllers')
    @can('edit', $postGroup)
    <div class="controllers">
        <a href="{{ route('post.create', ['postGroup' => $postGroup]) }}" class="controllersButton">Add item</a>
        |
        @if(isset($type) and $type === 'archive')
            <a href="{{ route('wishlist', ['postGroup' => $postGroup]) }}">Current wished</a>
        @else
            <a href="{{ route('wishlist.archive', ['postGroup' => $postGroup, 'type' => 'archive']) }}">Archived wished</a>
        @endif
    </div>
    @endcan
@endsection

@section('content')
<div class="wishlistWrapper">
@foreach($posts as $post)
    <div class="item">
        @if(object_get($post->images()->first(), 'path'))
        <a href="{{ route('post.show', ['post' => $post->id]) }}">
            <div class="itemImage" style="background-image: url(/storage/{{ object_get($post->images()->first(), 'path') }});"></div>
        </a>
        @endif
        <div class="itemText">
            {!! $post->text_parsed !!}
            <div><a href="{{ route('post.show', ['post' => $post->id]) }}">Permalink</a> | <a href="{{ route('post.archive', ['post' => $post->id]) }}">Archive</a></div>
        </div>
    </div>
@endforeach
</div>
@endsection
