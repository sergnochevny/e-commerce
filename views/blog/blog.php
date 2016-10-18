<style>
    .just-posts-grid .just-post {
        margin: 20px 0;
    }

    .just-posts-grid .just-post-image {
        background-position: top center;
        background-size: cover;
        height: 220px;
        margin: 0 0 20px;
        overflow: hidden;
        box-shadow: 0 5px 15px -1px rgba(0,0,0,.2);
    }

    .just-posts-grid .just-post-image a {
        display: block;
        height: 220px;
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
        background-image: url("<?= _A_::$app->router()->UrlTo('views/images/bg-opa.png'); ?>");
        bottom: 0;
        display: block;
        height: 80px;
        position: absolute;
        width: 100%;
    }
</style>
<div class="site-container">
    <?php
        include("views/shop_header.php");
        include('views/index/main_gallery.php');
    ?>

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

                                                    <p class="woocommerce-result-count" style="font-size: 18px;">
                                                        <?php
                                                            if (!empty(_A_::$app->get('cat'))) {
                                                                echo 'CATEGORY: ' . $category_name . '<br/>';
                                                            }
                                                            echo isset($count_rows) ? "Showing " . $count_rows . " results" : "Showing ... results";
                                                        ?>

                                                    </p>

                                                    <section class="just-posts-grid">
                                                        <div class="just-post-row row">
                                                            <?= isset($blog_posts) ? $blog_posts : ''; ?>
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
                        <h4 class="sr-only">Navigation</h4>
                        <ul class="pagination">
                            <?= isset($paginator) ? $paginator : ''; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script src='<?= _A_::$app->router()->UrlTo('views/js/blog/blog.js'); ?>' type="text/javascript"></script>