<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<script type="text/javascript" src="upload/js/ajaxupload.3.5.js"></script>
<!---<script src="<?php _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js') ?>"></script>--->
<script src="<?php _A_::$app->router()->UrlTo('tinymce/tinymce.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php _A_::$app->router()->UrlTo('views/css/jquery-ui.css') ?>" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _A_::$app->router()->UrlTo('views/css/jquery-ui.theme.css') ?>" media="all"/>

<link rel='stylesheet' href='<?php _A_::$app->router()->UrlTo('views/css/style.css') ?>' type='text/css' media='all'/>
<link rel="stylesheet" type="text/css" href="<?php _A_::$app->router()->UrlTo('upload/styles.css') ?>">

<style>
    .toko-posts-grid .toko-post {
        margin: 0 0 20px;
    }

    .toko-posts-grid .toko-post-image {
        background-position: center center;
        background-size: cover;
        height: 200px;
        margin: 0 0 20px;
        overflow: hidden;
    }

    .toko-posts-grid .toko-post-image a {
        display: block;
        height: 200px;
    }

    .toko-posts-grid .toko-post-detail .post-title {
        margin: 0;
        font-size: 20px;
        font-weight: lighter;
        text-transform: uppercase;
        padding: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .toko-posts-grid .toko-post-detail .post-title a {
        color: #222222;
    }

    .toko-posts-grid .toko-post-detail .post-date {
        font-size: 14px !important;
        color: #5f5f5f !important;
        text-transform: uppercase;
        font-weight: normal;
        padding: 0;
    }

    .toko-posts-grid .toko-post-detail > p {
        display: block;
        font-size: 12px;
        font-weight: normal;
        height: 100px;
        margin: 0;
        overflow: hidden;
        padding: 0;
        position: relative;
    }

    .toko-posts-grid .toko-post-detail > p > span.opa {
        background-image: url("<?php _A_::$app->router()->UrlTo('views/images/bg-opa.png');?>");
        bottom: 0;
        display: block;
        height: 80px;
        position: absolute;
        width: 100%;
    }

</style>

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?php echo $back_url;?>"  class="back_button"><input type="submit" value="Back" class="button"></a>
                <center>
                    <h6>EDIT BLOG POST</h6>
                </center>
                <div id="customer_details" class="col2-set">
                    <div class="woocommerce">
                        <div  id="blog_post_form">
                        <?php
                        include('views/blog/blog_edit_post_form.php');
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

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
                            external_filemanager_path: "<?php _A_::$app->router()->UrlTo('filemanager/') ?>",
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
            );

            $(document).ready(
                function(){
                    $(document).trigger('tiny_init');

                    $(document).on('mouseenter','input[name=uploadfile]',
                        function(event){
                            $('#post_img').css('border','dotted');
                        }
                    );

//                    $(document).on('mouseover','#post_img',
//                        function(event){
//                            debugger;
//                            $(this).css('border','dotted');
//                        }
//                    );

                    $(document).on('mouseleave','input[name=uploadfile]',
                        function(event){
                            $('#post_img').css('border','');
                        }
                    );
                }
            );

            $(document).on('click', '#pre_save',
                function (event) {
                    event.preventDefault();
                    $('[data-id=blog_post_form_dialog]').each(
                        function(){
                            $(this).css('display','block');
                        }
                    );
                    $('html, body').animate({scrollTop: parseInt($('#blog_post_form_dialog').offset().top) - 100}, 1000);
//                    $('#blog_post_form_dialog').dialog({
//                        title: 'Saving Article.',
//                        minWidth: 600,
//                        modal: true,
//                        resizable: false
//                    });
                }
            );

            $(document).on('submit', '#blog_post',
                function (event) {
                    event.preventDefault();
//                    $('#blog_post_form_dialog').dialog('close');
//                    $('#blog_post_form_dialog').dialog('destroy');
                    $('[name=title]').val(tinyMCE.get('editable_title').getContent());
                    $('[name=content]').val(tinyMCE.get('editable_content').getContent());
//                    tinymce.remove();
                    var msg = $(this).serialize();
                    var url = $(this).attr('action');
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

                                    $(document).trigger('tiny_init');
//                                    $('#blog_post_form_dialog').dialog({
//                                        title: 'Saving Article.',
//                                        minWidth: 600,
//                                        modal: true,
//                                        resizable: false
//                                    });
                                    if ($('.danger').length > 0) {
                                        $('.danger').css('display', 'block');
                                        $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250}, 1000);
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
    </script>