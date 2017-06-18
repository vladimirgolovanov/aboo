document.addEventListener('DOMContentLoaded', function(){ 

    var token = document.querySelector('input[name=_token]');
    console.log(token.value);
    var post_id = document.querySelector('input[name=post_id]');
    var post_group_id = document.querySelector('input[name=post_group_id]');

    var images = document.querySelectorAll('.js-image_item')
    var clickToDelImage = function (el) {
        var delImage = el.currentTarget;
        var route = delImage.dataset.route;
        var request = new XMLHttpRequest();
        request.open('GET', route);
        request.send();
        delImage.parentElement.remove();
    }
    Array.prototype.forEach.call(images, function (el, i) {
        el.querySelector('span.js-image_item_delete').addEventListener('click', function (el) {
            clickToDelImage(el);
        });
    });

    var timeout = null;
    var editableText = document.querySelector('.js-editable_text');
    if (editableText) {
        editableText.addEventListener('input', function (e) {
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
                    document.querySelector('.js-textarea_alert').innerHTML = 'saved';
                };
                setTimeout(function () {
                    document.querySelector('.js-textarea_alert').innerHTML = '';
                }, 3000);

                // todo: add 'saved' + timeout fadeout
            }, 3000);
        });
    }

    var imageItemAdd = document.querySelector('.js-image_item_add');
    if (imageItemAdd) {
        imageItemAdd.addEventListener('change', function (e) {
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
            request.open('POST', '/post/upload_image');

            request.send(formData);

            request.onload = function() {
                input.value = "";
                var image_data = JSON.parse(this.response);
                if (this.status === 200) { // else?
                    var div = document.createElement('div');
                    div.classList.add('editImage');
                    div.classList.add('js-image_item');
                    div.innerHTML = '<div class="editImageImg" style="background: #ccc;">' +
                                    //'<img src="/storage/' + image_data.path + '">' +
                                    '</div>' +
                                    '<span class="js-image_item_delete" data-route="' + image_data.destroy_image_route + '">Delete</span>';
                    var listImages = document.querySelector('.js-image_items');
                    var addImageButton = listImages.lastChild;
                    console.log(addImageButton);
                    //listImages.appendChild(div);
                    listImages.insertBefore(div, addImageButton);
                    //var addedImage = listImages.lastChild;
                    var addedImage = addImageButton.previousSibling;
                    addedImage.querySelector('span.js-image_item_delete').addEventListener('click', function (el) {
                        clickToDelImage(el);
                    });
                }
            };

        });
    }

    var editHeader = document.querySelector('.js-edit_header_icon');
    if (editHeader) {
        editHeader.addEventListener('click', function (e) {
            document.querySelector('h1').style.display = 'none';
            document.querySelector('.js-edit_header_input').style.display = 'block';
            document.querySelector('.js-edit_header_input input').focus();
            document.querySelector('.js-edit_header_icon').style.display = 'none';
        });
        var input = document.querySelector('.js-edit_header_input input');
        input.addEventListener('input', function (e) {
            // todo: change bordercolor oninput and onsave
            if (timeout !== null) {
                clearTimeout(timeout);
                timeout = null;
            }

            timeout = setTimeout(function () {
                var formData = new FormData();

                formData.append(input.name, input.value);

                formData.append(token.name, token.value);
                formData.append(post_group_id.name, post_group_id.value);

                var request = new XMLHttpRequest();
                request.open('POST', '/post/save_post_group_header');
                request.send(formData);

                request.onload = function() {
                    console.log('Request Status', request.status, request.response);
                    document.querySelector('h1').innerHTML = input.value;
                };
            }, 3000);
        });
        
        input.addEventListener('focusout', function (e) {
            document.querySelector('.js-edit_header_input').style.display = 'none';
            document.querySelector('.js-edit_header_icon').style.display = 'block';
            document.querySelector('h1').style.display = 'block';
        });
    }

}, false);
