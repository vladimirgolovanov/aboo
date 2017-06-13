@extends('layouts.master')

@section('header')
    <h1>{{ $user->username }}</h1>
@endsection

@section('content')

    @foreach($postGroupTypes as $postGroupType)
        @if(array_get($groupedPosts, $postGroupType->id))
            @if($postGroupType->post_group_type_id == 1)
                <h2><a href="{{ route('collection', ['postGroup' => $postGroupType->id]) }}">{{ $postGroupType->name }}</a></h2>
            @elseif($postGroupType->post_group_type_id == 2)
                <h2><a href="{{ route('wishlist', ['postGroup' => $postGroupType->id]) }}">{{ $postGroupType->name }}</a></h2>
            @endif
            <div class="previewCollectionItems">
            @foreach($groupedPosts[$postGroupType->id] as $post)
                <a
                    href="{{ route('post.show', ['post' => $post->id]) }}"
                    class="previewCollectionItem"
                    style="background-image: url(/storage/{{ object_get($post->images->first(), 'path') }});"
                ></a>
            @endforeach
            </div>
        @endif
    @endforeach

@endsection
