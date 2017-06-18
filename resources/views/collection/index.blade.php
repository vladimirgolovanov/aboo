@extends('layouts.master')

@section('header')
    <h1>{{ $postGroup->name or 'Collection' }}</h1>
    @can('edit', $postGroup)
    {{ csrf_field() }}
    <input type="hidden" name="post_group_id" value="{{ $postGroup->id }}">
    <div class="editHeaderInput js-edit_header_input">
        <input type="text" name="name" value="{{ $postGroup->name or 'Collection' }}">
    </div>
    <div class="editHeader js-edit_header_icon"></div>
    @endcan
@endsection

@section('controllers')
    @can('edit', $postGroup)
    <div class="controllers">
        <a href="{{ route('post.create', ['postGroup' => $postGroup]) }}" class="controllersButton">Add item</a>
        |
        @if(isset($type) and $type === 'archive')
            <a href="{{ route('collection', ['postGroup' => $postGroup]) }}">Current items</a>
        @else
            <a href="{{ route('collection.archive', ['postGroup' => $postGroup, 'type' => 'archive']) }}">Archived items</a>
        @endif
    </div>
    @endcan
@endsection

@section('content')
<div class="itemsWrapper">
@foreach($posts as $post)
    <div class="item">
        <a href="{{ route('post.show', ['post' => $post->id]) }}">
            {{-- <img src="/storage/{{ object_get($post->images()->first(), 'path') }}" /> --}}
            @if(object_get($post->images()->first(), 'path'))
            <div class="itemImage" style="background-image: url(/storage/{{ object_get($post->images()->first(), 'path') }});"></div>
            @endif
            <div class="itemText">{{ $post->text_parsed }}</div>
        </a>
    </div>
@endforeach
</div>
@endsection
