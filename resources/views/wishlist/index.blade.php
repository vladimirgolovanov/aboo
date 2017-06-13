@extends('layouts.master')

@section('header')
    <h1>Wishlist</h1>
@endsection

@section('controllers')
<div class="controllers">
    <a href="{{ route('post.create', ['postGroup' => $postGroup]) }}" class="controllersButton">add item</a>
</div>
@endsection

@section('content')
<div class="wishlistWrapper">
@foreach($posts as $post)
    <div class="item">
        <a href="{{ route('post.show', ['post' => $post->id]) }}">
            <div class="itemText">{{ $post->text_parsed }}</div>
            <div class="itemImage" style="background-image: url(/storage/{{ object_get($post->images()->first(), 'path') }});"></div>
        </a>
    </div>
@endforeach
</div>
@endsection
