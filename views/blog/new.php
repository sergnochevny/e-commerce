<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<script src="<?php _A_::$app->router()->UrlTo('tinymce/tinymce.min.js')?>"></script>
<script type="text/javascript" src="<?php _A_::$app->router()->UrlTo('upload/js/ajaxupload.3.5.js')?>"></script>
<link rel='stylesheet' id='just-style-css' href='<?php _A_::$app->router()->UrlTo('views/css/style.css')?>' type='text/css' media='all'/>
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
    <input type="hidden" id="external_filemanager_path" value="<?= _A_::$app->router()->UrlTo('filemanager/')?>">
    <input type="hidden" id="ajax_ret_act" value="<?= _A_::$app->router()->UrlTo('blog/new_upload_img')?>">
    <script src='<?= _A_::$app->router()->UrlTo('views/js/blog/new.js'); ?>' type="text/javascript"></script>