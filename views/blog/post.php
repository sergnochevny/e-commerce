<body class="home page page-template page-template-page_visual_composer page-template-page_visual_composer-php header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive woocommerce">
<div class="site-container">
    <?php
        include "views/shop_header.php";
        include('views/index/main_gallery.php');
    ?>

    <style>
        .just-posts-grid .just-post {
            margin: 0 0 20px;
        }

        .just-posts-grid .just-post-image {
            background-position: center center;
            background-size: cover;
            height: 200px;
            margin: 0 0 20px;
            overflow: hidden;
        }

        .just-posts-grid .just-post-image a {
            display: block;
            height: 200px;
        }

        .just-posts-grid .just-post-detail .post-title {
            margin: 0;
            font-size: 20px;
            font-weight: lighter;
            text-transform: uppercase;
            padding: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .just-posts-grid .just-post-detail .post-title a {
            color: #222222;
        }

        .just-posts-grid .just-post-detail .post-date {
            font-size: 14px !important;
            color: #5f5f5f !important;
            text-transform: uppercase;
            font-weight: normal;
            padding: 0;
        }

        .just-posts-grid .just-post-detail > p {
            display: block;
            font-size: 12px;
            font-weight: normal;
            height: 100px;
            margin: 0;
            overflow: hidden;
            padding: 0;
            position: relative;
        }

        .just-posts-grid .just-post-detail > p > span.opa {
            background-image: url("<?php _A_::$app->router()->UrlTo('views/images/bg-opa.png');?>");
            bottom: 0;
            display: block;
            height: 80px;
            position: absolute;
            width: 100%;
        }

    </style>

    <div class="main-content main-content-shop">
        <div class="container"> <br/> <?= isset($blog_post) ? $blog_post : ''; ?> </div>
    </div>
    <script src='<?= _A_::$app->router()->UrlTo('views/js/scroll.down.js'); ?>' type="text/javascript"></script>