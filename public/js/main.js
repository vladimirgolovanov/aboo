document.addEventListener('DOMContentLoaded', function(){ 

    var token = document.querySelector('input[name=_token]');
    var post_id = document.querySelector('input[name=post_id]');

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

    document.querySelector('.js-image_item_add').addEventListener('change', function (e) {
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

}, false);
