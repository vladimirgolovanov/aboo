@extends('layouts.master')

@section('header')
    <h1>
    @if(!empty($tag))
        <a href="{{ route('wishlist', ['postGroup' => $postGroup]) }}">Wishlist</a>
        #{{ $tag->name }}
    @else
        Wishlist
    @endif
    </h1>
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
