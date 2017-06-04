@extends('layouts.master')

@section('header')
    <p>Back to <a href="{{ route('collection', ['postGroup' => $post->post_group_id]) }}">Collection</a></p>
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

    <div class="editImages">
    @foreach($postImages as $postImage)
        <div class="editImage">
            <img src="/storage/{{ $postImage->path }}">
            <span data-route="{{ route('post.destroy_image', ['image' => $postImage]) }}">del</span>
        </div>
    @endforeach
    </div>

    {{ $errors->has('image') ? 'has-error' : '' }}
    <label for="image" class="itemImageInputLabel">Add image</label>
    <input id="image" class="itemImageInput" type="file" name="image">
    @if ($errors->has('image'))
        {{ $errors->first('image') }}
    @endif
</form>

<script>
var token = document.querySelector('input[name=_token]');
var post_id = document.querySelector('input[name=post_id]');

var images = document.querySelectorAll('.editImage')
var clickToDelImage = function (el) {
    var delImage = el.currentTarget;
    var route = delImage.dataset.route;
    var request = new XMLHttpRequest();
    request.open('GET', route);
    request.send();
    delImage.parentElement.remove();
}
Array.prototype.forEach.call(images, function (el, i) {
    el.querySelector('span').addEventListener('click', function (el) {
        clickToDelImage(el);
    });
});

var timeout = null;
document.querySelector('.js-editable_text').addEventListener('input', function (e) {
    var text = e.currentTarget;
    var form = text.parentElement;

    if (timeout !== null) {
        clearTimeout(timeout);
        timeout = null;
    }

    timeout = setTimeout(function () {
        var formData = new FormData();

        formData.append(text.name, text.value);

        formData.append(token.name, token.value);
        formData.append(post_id.name, post_id.value);

        var request = new XMLHttpRequest();
        request.open('POST', '/post/save_text');
        request.send(formData);

        request.onload = function() {
            console.log('Request Status', request.status, request.response);
        };

        // todo: add 'saved' + timeout fadeout
    }, 3000);
});

document.querySelector('.itemImageInput').addEventListener('change', function (e) {
    var input = e.currentTarget;

    var form = input.parentElement;
    var formData = new FormData();

    formData.append(token.name, token.value);
    formData.append(post_id.name, post_id.value);

    var input = form.querySelector('input[type=file]');
    if (input.value) {
        formData.append(input.name, input.files[0]);
    }

    var request = new XMLHttpRequest();
    request.open(form.method, '/post/upload_image');
    request.send(formData);

    request.onload = function() {
        input.value = "";
        var image_data = JSON.parse(this.response);
        if (this.status === 200) { // else?
            var div = document.createElement('div');
            div.classList.add('editImage');
            div.innerHTML = '<img src="/storage/' + image_data.path + '">' +
                            '<span data-route="' + image_data.destroy_image_route + '">del</span>';
            var listImages = document.querySelector('.editImages');
            listImages.appendChild(div);
            var addedImage = listImages.lastChild;
            addedImage.querySelector('span').addEventListener('click', function (el) {
                clickToDelImage(el);
            });
        }
    };

});

</script>
@endsection
