<body
    class="home page page-template page-template-page_visual_composer page-template-page_visual_composer-php header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive">

<div class="site-container">
    <?php
    include "views/shop_header.php";

    include('views/index/main_gallery.php');
    ?>

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

    <div class="main-content" id="blog-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="page type-page status-publish entry">
                        <br/><br/>

                        <h1 class="entry-title">I Luv Fabrix Blog</h1>

                        <div class="entry-content">
                            <div class="vc_row wpb_row vc_row-fluid">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                                <div class="wpb_wrapper">

                                                    <p class="woocommerce-result-count">
                                                        <?php
                                                        if (!empty(_A_::$app->get('cat'))) {
                                                            echo 'CATEGORY: '.$catigori_name.'<br/>';
                                                        }
                                                        echo isset($count_rows) ? "Showing " . $count_rows . " results" : "Showing ... results";
                                                        ?>

                                                    </p>

                                                    <section class="toko-posts-grid">
                                                        <div class="toko-post-row row">
                                                            <?php echo isset($blog_posts)?$blog_posts:'';?>
                                                            <div class="clearfix visible-md visible-lg"></div>
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <nav class="paging-navigation" role="navigation">
                        <h4 class="sr-only">Post navigation</h4>
                        <ul class="pagination">
                            <?php
                            echo isset($paginator) ? $paginator : '';
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        (function ($) {
            $(document).ready(
                function (event) {

                    setTimeout(function () {
                        $('html, body').stop().animate({
                            scrollTop: $('#blog-page').offset().top
                        }, 2000);
                    }, 300);
                }
            );
        })(jQuery);

    </script>

    <?php
    include('views/product/block_footer_products.php');
    ?>