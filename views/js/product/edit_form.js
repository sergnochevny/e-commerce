'use strict';
(function($){
    var btnUpload = $('#upload'),
        status1 = $('#status'),
        danger = $('.danger');

    if(danger.length){
        danger.css('display','block');
        $('html, body').stop().animate({scrollTop: parseInt(danger.offset().top) - 250 }, 1000);
    }

    setTimeout(function(){
        $('.danger').css('display','none');
    },8000);

    new AjaxUpload(btnUpload, {
        action: function(){
            var images = $('input[name=images]:checked'),
                idx = (!images .val()) ? 1 : images .val();
            return $('#product_upload_img').val() + "&idx="+idx;
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
        function(event) {
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

})(jQuery);