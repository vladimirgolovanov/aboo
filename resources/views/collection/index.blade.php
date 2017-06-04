@extends('layouts.master')

@section('header')
    <h1>Collection</h1>
@endsection

@section('controllers')
<div class="controllers">
    <a href="{{ route('post.create', ['postGroup' => $postGroup]) }}" class="controllersButton">add item</a>
</div>
@endsection

@section('content')
<div class="itemsWrapper">
@foreach($posts as $post)
    <div class="item">
        <a href="{{ route('post.show', ['post' => $post->id]) }}">
            <img src="/storage/{{ object_get($post->images()->first(), 'path') }}" />
            <div class="itemText">{{ $post->text_parsed }}</div>
        </a>
    </div>
@endforeach
</div>
@endsection
