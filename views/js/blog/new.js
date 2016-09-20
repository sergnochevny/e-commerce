'use strict';

(function($){

    $(document).on('init_form',
        function(){
            tinymce.init(
                {
                    selector:'textarea#editable',
                    images_upload_base_path: '/img/blog',
                    height: 500,
                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks fullscreen",
                        "code",
                        "insertdatetime table contextmenu paste imagetools textcolor responsivefilemanager"
                    ],
                    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                    toolbar2: "| responsivefilemanager  image | link unlink anchor | forecolor backcolor  | print preview code ",
                    image_advtab: true,
                    external_filemanager_path: $('#external_filemanager_path').val(),
                    relative_urls: false,
                    remove_script_host: false
                }
            );

            var btnUpload = $('#upload');
            new AjaxUpload(btnUpload, {
                action: function(){
                    return $('#ajax_ret_act').val()
                },
                name: 'uploadfile',
                onComplete: function (file, response) {
                    var danger = $('.danger');
                    $('.b_modify_image_pic').html(response);

                    if(danger.length>0){
                        $('html, body').stop().animate({
                            scrollTop: parseInt(danger.offset().top) - 250
                        }, 1000);
                        setTimeout(function(){
                            $('.danger').remove();
                        },8000);
                    }

                }
            });

        }
    );

    $(document).on('submit', 'form#blog_post',
        function(event) {
            event.preventDefault();
            tinyMCE.triggerSave();
            var msg = $(this).serialize();
            var url = $(this).attr('action');
            tinymce.remove();
            $.ajax({
                type: 'POST',
                url: url,
                data: msg,
                success: function (data) {
                    $.when(
                        $('#blog_post_form').html(data)
                    ).done(
                        function(){
                            var danger = $('.danger');
                            $(document).trigger('init_form');

                            if(danger.length > 0){
                                danger.css('display','block');
                                $('html, body').stop().animate({
                                    scrollTop: parseInt(danger.offset().top) - 250
                                }, 1000);
                                setTimeout(function(){
                                    danger.remove();
                                },8000);
                            }

                        }
                    );
                },
                error: function (xhr, str) {
                    alert('Error: ' + xhr.responseCode);
                }
            });
        }
    );

    $(document).ready(
        function(){
            $(document).trigger('init_form');
        }
    );

})(jQuery);