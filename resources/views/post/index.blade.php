@extends('layouts.master')

@section('content')

    {{-- todo: refactor to less php --}}
    @foreach($postGroupTypes as $postGroupType)
        @if(!$postGroupType->id)
            <a href="{{ route('post.create_post_group', ['postGroupType' => $postGroupType->post_group_type_id]) }}">create group</a>
        @elseif(array_get($groupedPosts, $postGroupType->id))
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
        @else
            create group {{-- todo: go to create item --}}
        @endif
    @endforeach

@endsection
