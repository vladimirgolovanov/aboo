@extends('post.item')

@section('content')
    {!! $post->text_parsed !!}
    
    @if($postImages->count() === 1)
        <div class="showSingleItemImage">
            <div class="itemImage" style="background-image: url(/storage/{{ $postImages->first()->path }});"></div>
        </div>
    @else
        <div class="showItemImages">
        @foreach($postImages as $postImage)
            <div class="showItemImage">
                <div class="itemImage" style="background-image: url(/storage/{{ $postImage->path }});"></div>
            </div>
        @endforeach
        </div>
    @endif
@endsection
