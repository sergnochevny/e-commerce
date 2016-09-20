<body
    class="home page page-template page-template-page_visual_composer page-template-page_visual_composer-php header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive">

<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/simple-line-icons.css'); ?>' type='text/css' media='all'/>
<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/matches.css'); ?>' type='text/css' media='all'/>

<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>' type='text/css' media='all'/>
<script type='text/javascript' charset="UTF-8" src='<?php echo _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

<div class="site-container">
    <?php include "views/shop_header.php"; ?>

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

    <div class="main-content" id="matches-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="page type-page status-publish entry">
                        <br/><br/>

                        <h1 class="entry-title">I Luv Fabrix Matches</h1>

                        <div class="entry-content">
                            <div class="vc_row wpb_row vc_row-fluid">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                                <div class="wpb_wrapper">
                                                    <section class="just-posts-grid">
                                                        <div class="note">
                                                            <div class="matches-note">
                                                                NOTE:
                                                            </div>
                                                            <div class="matches-note-text">
                                                                <p align="left">
                                                                    <b>In
                                                                        &laquo;Matches&raquo; you can mix and match your
                                                                        fabric samples by dragging them into the work
                                                                        area below.
                                                                        Experiment with possible combinations and have fun.
                                                                        <br/>
                                                                        If you want to purchase a fabric in matches area
                                                                        press to &laquo;Add All to Basket&raquo;.
                                                                        <br/>
                                                                        If you want to remove a fabric from
                                                                        your &laquo;Matches&raquo; drag it to the trash
                                                                        can.
                                                                        <br/>
                                                                        If you want to remove all fabric from
                                                                        your &laquo;Matches&raquo; press to &laquo;Clear
                                                                        Matches&raquo;.<br>
                                                                        Before experiment with other fabrics you need to
                                                                        clear the area by clicking &laquo;Clear Matches&raquo;.
                                                                    </b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div id="dragZone">
                                                            <div class="dragZoneTitle">Matches Area</div>
                                                            <div id="dragZoneArea">
                                                                <div class="deleteDragImg icon-delete"></div>
                                                                <div class="detailsDragImg"></div>
                                                                <?= isset($matches_items) ? $matches_items : '' ?>
                                                            </div>
                                                        </div>
                                                        <b id="b_in_product">
                                                            <a id="all_to_basket" href="<?= _A_::$app->router()->UrlTo('matches/all_to_cart'); ?>">
                                                                Add All to Basket
                                                            </a>
                                                            <a id="clear_matches"
                                                               href="<?= _A_::$app->router()->UrlTo('matches/clear'); ?>">
                                                                Clear Matches
                                                            </a>
                                                        </b>

                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="base_url" value="<?= _A_::$app->router()->UrlTo('/'); ?>">
    <script src='<?= _A_::$app->router()->UrlTo('views/js/matches/matches.js'); ?>' type="text/javascript"></script>

<?php
include('views/product/block_footer.php');
?>