    <script defer src="<?= _A_::$app->router()->UrlTo('upload/js/ajaxupload.3.5.js') ?>" type="text/javascript"></script>
    <script defer src="<?= _A_::$app->router()->UrlTo('tinymce/tinymce.min.js') ?>" type="text/javascript"></script>
    <script defer src='<?= _A_::$app->router()->UrlTo('views/js/blog/edit.js'); ?>' type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.css') ?>" media="all"/>
    <link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.theme.css') ?>" media="all"/>

    <link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/style.css') ?>' type='text/css' media='all'/>
    <link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('upload/styles.css') ?>">

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
            background-image: url("<?= _A_::$app->router()->UrlTo('views/images/bg-opa.png');?>");
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
                    <a href="<?= $back_url;?>" class="button back_button">Back</a>
                    <div class="text-center">
                        <h6>EDIT BLOG POST</h6>
                    </div>
                    <div class="col2-set">
                        <div class="woocommerce"><div id="blog_post_form"><?php include('views/blog/edit_form.php'); ?></div></div>
                    </div>
                </div>
            </div>
        </div>
