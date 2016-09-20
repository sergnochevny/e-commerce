'use strict';
(function ($) {

    new AjaxUpload($('#post_img'), {
        action: function(){
            return $('#retAct').val()
        },
        name: 'uploadfile',
        onComplete: function (file, response) {
            try{
                var imgs = JSON.parse(response);
                $("#post_img").css('background-image', 'url("'+imgs.img+'")');
                $("#img").val(imgs.f_img);
            } catch(e){

            }
            $('input[name=uploadfile]').trigger('mouseleave');
        }
    });

    $("#save").on('click',function(event){
        event.preventDefault();
        $('#blog_post').trigger('submit');
    });

    $("#close").on('click',function(event){
        $('[data-id=blog_post_form_dialog]').each(function(){
            $(this).css('display','none');
        });
    });
})(jQuery);