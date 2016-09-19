'use strict';

(function ($) {

    $(document).on('tiny_init',
        function(event){
            tinymce.init(
                {
                    selector: '#editable_content',
                    images_upload_base_path: '/img/blog',
                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks fullscreen",
                        "code",
                        "insertdatetime table contextmenu paste imagetools textcolor responsivefilemanager"
                    ],
                    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                    toolbar2: "| responsivefilemanager  image | link unlink anchor | forecolor backcolor  | print preview code ",
                    image_advtab: true,
                    external_filemanager_path: "<?= _A_::$app->router()->UrlTo('filemanager/') ?>",
                    relative_urls: false,
                    remove_script_host: false,
                    inline: true
                }
            );

            tinymce.init(
                {
                    selector: '#editable_title',
                    menubar: false,
                    toolbar: false,
                    inline: true
                }
            );
        }
    ).ready(
        function(){
            $(document)
                .trigger('tiny_init')
                .on('mouseenter','input[name=uploadfile]',function(event){
                    $('#post_img').css('border','dotted');
                }).on('mouseleave','input[name=uploadfile]',function(event){
                $('#post_img').css('border','');
            });
        }
    ).on('click', '#pre_save',
        function (event) {
            event.preventDefault();
            $('[data-id=blog_post_form_dialog]').each(
                function(){
                    $(this).css('display','block');
                }
            );
            $('html, body').stop().animate({scrollTop: parseInt($('#blog_post_form_dialog').offset().top) - 100}, 1000);
//                    $('#blog_post_form_dialog').dialog({
//                        title: 'Saving Article.',
//                        minWidth: 600,
//                        modal: true,
//                        resizable: false
//                    });
        }
    ).on('submit', '#blog_post',
        function (event) {
            event.preventDefault();
//                    $('#blog_post_form_dialog').dialog('close');
//                    $('#blog_post_form_dialog').dialog('destroy');
            $('[name=title]').val(tinyMCE.get('editable_title').getContent());
            $('[name=content]').val(tinyMCE.get('editable_content').getContent());
//                    tinymce.remove();
            var msg = $(this).serialize(),
                url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: msg,
                success: function (data) {
                    $.when(
//                                $('#blog_post_form').html(data)
                        $('#alert').html(data)
                    ).done(
                        function(){
                            var danger = $('.danger');
                            $(document).trigger('tiny_init');
//                                    $('#blog_post_form_dialog').dialog({
//                                        title: 'Saving Article.',
//                                        minWidth: 600,
//                                        modal: true,
//                                        resizable: false
//                                    });
                            if (danger.length > 0) {
                                danger.css('display', 'block');
                                $('html, body').stop().animate({
                                    scrollTop: parseInt(danger.offset().top) - 250
                                }, 1000);
                                setTimeout(function () {
                                    $('.danger').remove();
                                }, 8000);
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

})(jQuery);