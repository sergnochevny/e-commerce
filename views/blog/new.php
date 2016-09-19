<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<script src="<?php _A_::$app->router()->UrlTo('tinymce/tinymce.min.js')?>"></script>
<script type="text/javascript" src="<?php _A_::$app->router()->UrlTo('upload/js/ajaxupload.3.5.js')?>"></script>
<link rel='stylesheet' id='toko-style-css' href='<?php _A_::$app->router()->UrlTo('views/css/style.css')?>' type='text/css' media='all'/>
<link rel="stylesheet" type="text/css" href="<?php _A_::$app->router()->UrlTo('upload/styles.css')?>">

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">

                <a href="<?= $back_url;?>"  class="back_button"><input type="submit" value="Back" class="button"></a>

                <h1 class="page-title">ADD BLOG POST</h1>

                <div id="customer_details" class="col2-set">
                    <div class="woocommerce">
                        <div  id="blog_post_form"><?php include('views/blog/blog_new_post_form.php'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
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
                            external_filemanager_path:"<?php _A_::$app->router()->UrlTo('filemanager/')?>",
                            relative_urls: false,
                            remove_script_host: false
                        }
                    );

                    var btnUpload = $('#upload');
                    new AjaxUpload(btnUpload, {
                        action: function(){
                            return '<?php _A_::$app->router()->UrlTo('blog/new_upload_img')?>'
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
    </script>