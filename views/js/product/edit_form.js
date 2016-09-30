'use strict';

// Inputmask
(function(){
    var p_yard = document.getElementById('p_yard'),
        m_width = document.getElementById('m_width'),
        current_inv = document.getElementById('current_inv'),
        float_type = '9[9].9[9]',
        long_float_type = '9[9{2}].9[9]';

    Inputmask({ alias: 'currency', rightAlign: false }).mask(p_yard);
    Inputmask({ mask: float_type, greedy: false}).mask(m_width);
    Inputmask({ mask: long_float_type, greedy: false}).mask(current_inv);

}).call(this);


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
            var data = new FormData(this);
            var url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                cache: false,
                processData: false,
                contentType: false,
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
                success: function (data) {
                    $.when(
                        form.find('.prod_sel_category').html(data)
                    ).done(
                        function () {
                            $('span.rem_cat').on('click',
                                function (event) {
                                    evRemoveCategories.call(this, event);
                                }
                            );
                        }
                    );
                },
                complete: function () {
                    form.waitloader('remove');
                }
            });
        }
    );
    function evRemoveCategories(event) {
        event.preventDefault();
        var cat_id = $(this).prev().find('input').attr('data-catid');
        var checked = false;
        $('ul.categories input').each(
            function () {
                if ($(this).val() == cat_id) this.checked = !this.checked;
                checked = checked || this.checked;
            }
        );
        $(this).parent('li.prod_sel_category_item').remove();
        if (!checked) {
            $('ul.categories input')[0].checked = true;
            $('form#product #build_categories').trigger('click');
        }
    }

    $('span.rem_cat').on('click',
        function (event) {
            evRemoveCategories.call(this, event);
        }
    );

})(jQuery);