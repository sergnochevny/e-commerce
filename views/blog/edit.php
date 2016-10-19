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
            background-position: center;
            background-size: cover;
            height: 300px;
            margin: 0 0 20px;
            overflow: hidden;
            box-shadow: 0 0 3px #DDD;
        }

        .just-posts-grid .just-post-image a {
            display: block;
            height: 200px;
        }

        .just-posts-grid .just-post-detail .post-title {
            margin: 0;
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

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row afterhead-row">
                    <div class="col-xs-12 back_button_container">
                        <div class="row">
                          <a href="<?= $back_url; ?>" class="button back_button">Back</a>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <div class="row">
                            <h3 class="page-title"><?= $form_title ?></h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 col-md-offset-2">
                <div class="woocommerce"><div id="blog_post_form"><?php include('views/blog/edit_form.php'); ?></div></div>
            </div>
        </div>
    </div>
