@extends('layouts.master')

@section('content')

    {{-- todo: refactor to less php --}}
    @foreach($postGroupTypes as $postGroupType)
        @if(!$postGroupType->id)
            {{-- <a href="{{ route('post.create_post_group', ['postGroupType' => $postGroupType->id]) }}">create group</a> --}}
        @else
            <h2><a href="{{ route('collection', ['postGroup' => $postGroupType->id]) }}">{{ $postGroupType->name }}</a></h2>
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
