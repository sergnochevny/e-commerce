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
                    <a href="<?= $back_url;?>" class="back_button">
                        <input type="submit" value="Back" class="button">
                    </a>
                    <div class="text-center">
                        <h6>EDIT BLOG POST</h6>
                    </div>
                    <div id="customer_details" class="col2-set">
                        <div class="woocommerce"><div id="blog_post_form"><?php include('views/blog/blog_edit_post_form.php'); ?></div></div>
                    </div>
                </div>
            </div>
        </div>
        <script src='<?= _A_::$app->router()->UrlTo('views/blog/edit.js'); ?>' type="text/javascript"></script>