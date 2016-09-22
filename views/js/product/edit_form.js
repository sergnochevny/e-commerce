'use strict';
(function ($) {
    var btnUpload = $('#upload'),
        status1 = $('#status'),
        danger = $('.danger');

    if (danger.length) {
        danger.css('display', 'block');
        $('html, body').stop().animate({scrollTop: parseInt(danger.offset().top) - 250}, 1000);
        setTimeout(function () {
            $('.danger').css('display', 'none');
        }, 8000);
    }

    new AjaxUpload(btnUpload, {
        action: function () {
            var images = $('input[name=images]:checked'),
                idx = (!images.val()) ? 1 : images.val();
            return $('#product_upload_img').val() + "&idx=" + idx;
        },
        name: 'uploadfile',
        onSubmit: function (file, ext) {
            if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                status.text('Error format');
                return false;
            }
        },
        onComplete: function (file, response) {
            if (response === "success") $('#modify_images2').load($("#image_modify").val());
        }
    });

    $('form#product').on('submit',
        function (event) {
            event.preventDefault();
            var msg = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: msg,
                success: function (data) {
                    $('#form_product').html(data);
                },
                error: function (xhr, str) {
                    alert('Error: ' + xhr.responseCode);
                }
            });
        }
    );
    $('form#product #edit_categories').on('click',
        function (event) {
            event.preventDefault();
            $('form#product #categories').modal('show');
        }
    );
    $('form#product #build_categories').on('click',
        function (event) {
            var form = $('form#product');
            var data = new FormData(form[0]);
            data.append('build_categories', true);
            var url = form.attr('action');
            form.waitloader('show');
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data){
                    form.find('.prod_sel_category').html(data);
                },
                complete: function(){
                    form.waitloader('remove');
                }
            });
        }
    )
    $(document).on('click', 'span.rem_cat',
        function(event){
            event.preventDefault();
            debugger;
            $(this).parent('li.prod_sel_category_item').remove();
        }
    );

})(jQuery);