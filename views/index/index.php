<body
    class="home page page-template page-template-page_visual_composer page-template-page_visual_composer-php header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive">

<!--Slider-->
<link rel='stylesheet' href='= _A_::$app->router()->UrlTo('views/css/owl.carousel.css'); ?>' type='text/css'
      media='all'/>
<script type='text/javascript' src='= _A_::$app->router()->UrlTo('views/js/owl.carousel.min.js'); ?>'></script>

<div class="site-container">
    <?php include "views/header.php"; ?>

    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="page type-page status-publish entry">
                        <div class="entry-content">
                            <div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true"
                                 class="vc_row wpb_row vc_row-fluid vc_custom_1439536789991 vc_row-no-padding">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="toko-slider-wrap">
                                            <div
                                                class="toko-slides toko-slider-active owl-carousel owl-theme owl-loaded">
                                                <div class="toko-slide"
                                                     style="background-image:url(= _A_::$app->router()->UrlTo('views/images/slider/slide1.jpg'); ?>);background-size:cover;background-position:center right;background-repeat:no-repeat;">
                                                    <div class="toko-slide-inner">
                                                        <div class="toko-slide-detail"
                                                             onclick="return location.href = '= _A_::$app->router()->UrlTo('shop'); ?>'">
                                                            <p class="toko-slide-desc">Featured Fabric Selection</p>

                                                            <h2 class="toko-slide-title">View our Fabrics</h2>
                                                            <a class="toko-slide-button"
                                                               href="= _A_::$app->router()->UrlTo('shop'); ?>">Click
                                                                to view our
                                                                fabrics</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="toko-slide"
                                                     style="background-image:url(= _A_::$app->router()->UrlTo('views/images/slider/slide2.jpg'); ?>);background-size:cover;background-position:center right;background-repeat:no-repeat;">
                                                    <div class="toko-slide-inner">
                                                        <div class="toko-slide-detail"
                                                             onclick="return location.href = '= _A_::$app->router()->UrlTo('shop'); ?>'">
                                                            <p class="toko-slide-desc">Featured Fabric Selection</p>

                                                            <h2 class="toko-slide-title">View our Fabrics</h2>
                                                            <a class="toko-slide-button"
                                                               href="= _A_::$app->router()->UrlTo('shop'); ?>">Click
                                                                to view our
                                                                fabrics</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vc_row-full-width"></div>
                            <div data-vc-full-width="true" data-vc-full-width-init="false"
                                 class="vc_row wpb_row vc_row-fluid vc_custom_1439733758005">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="toko-divider text-left line-no icon-hide">
                                            <div class="divider-inner" style="background-color: #fff">
                                                <h3 class="toko-section-title">Special For You</h3>

                                                <p class="paragraf">Best item collections in 2015 we have in store</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vc_row-full-width"></div>
                            <div class="vc_row wpb_row vc_row-fluid vc_custom_1439734400036">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="toko-woocommerce woocommerce columns-3 toko-carousel clearfix">

                                            <ul class="products owl-carousel" id="toko-carousel-871">

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-vc-full-width="true" data-vc-full-width-init="false"
                                 class="vc_row wpb_row vc_row-fluid vc_custom_1439734569149">
                                <div class="wpb_column vc_column_container vc_col-sm-12 vc_custom_1439734046393">
                                    <div class="wpb_wrapper">
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1439734506557">
                                            <div
                                                class="wpb_column vc_column_container vc_col-sm-12 vc_custom_1439734514225">
                                                <div class="wpb_wrapper">
                                                    <div class="toko-banner toko-banner-left"
                                                         style="background-image:url(= _A_::$app->router()->UrlTo('views/images/temp/textile.png'); ?>)">
                                                        <a href="= _A_::$app->router()->UrlTo('shop/last'); ?>">
                                                            <div class="toko-banner-detail">
                                                                <p class="paragraf1">Brand new life, Brand new
                                                                    textile</p>
                                                                <h3 class="text-big">What's New</h3>
                                                                <p class="paragraf2">Shop</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                            <div
                                                class="wpb_column vc_column_container vc_col-sm-6 vc_custom_1439734524172">
                                                <div class="wpb_wrapper">
                                                    <div class="toko-banner toko-banner-right" style="background-image:url(= _A_::$app->router()->UrlTo('views/images/temp/textile1.png'); ?>)">
                                                        <a href="= _A_::$app->router()->UrlTo('shop/best'); ?>">
                                                            <div class="toko-banner-detail">
                                                                <p class="paragraf1">New Collection</p>
                                                                <h3 class="text-medium">Best textile</h3>
                                                                <p class="paragraf2">Shop</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="wpb_column vc_column_container vc_col-sm-6 vc_custom_1439734531955">
                                                <div class="wpb_wrapper">
                                                    <div class="toko-banner toko-banner-left"
                                                         style="background-image:url(= _A_::$app->router()->UrlTo('views/images/temp/textile2.png'); ?>)">
                                                        <a href="= _A_::$app->router()->UrlTo('shop/popular'); ?>">
                                                            <div class="toko-banner-detail">
                                                                <p class="paragraf1">New collection</p>

                                                                <h3 class="text-medium">Popular textile</h3>

                                                                <p class="paragraf2">Shop</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vc_row-full-width"></div>
                            <div data-vc-full-width="true" data-vc-full-width-init="false"
                                 class="vc_row wpb_row vc_row-fluid vc_custom_1439734618195">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1439734668701">
                                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                                <div class="wpb_wrapper">
                                                    <div class="toko-cta text-center">
                                                        <h2 class="toko-cta-title">MOTHER'S DAY SALE</h2>

                                                        <p class="toko-cta-description">Limited Only 10 Days</p>
                                                        <a href="= _A_::$app->router()->UrlTo('shop'); ?>"
                                                           class="toko-cta-button">Shop
                                                            Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1439731815984">
                                            <div
                                                class="wpb_column vc_column_container vc_col-sm-12 vc_custom_1439745268547">
                                                <div class="wpb_wrapper">
                                                    <div class="toko-divider text-left line-no icon-hide">
                                                        <div class="divider-inner" style="background-color: #fff">
                                                            <h3 class="toko-section-title">Best Selling</h3>

                                                            <p class="paragraf">Best item collection in 2015 we have in
                                                                store</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                                <div class="wpb_wrapper">
                                                    <div
                                                        class="toko-woocommerce woocommerce columns-3 toko-no-carousel clearfix">
                                                        <ul class="products " id="toko-carousel-560">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vc_row-full-width"></div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">

    (function ($) {
        $(document).ready(
            function (event) {

                $('#toko-carousel-560').load("= _A_::$app->router()->UrlTo('shop/widget_bsells_horiz')?>");

                $('.toko-slider-active').owlCarousel({
                    items: 1,
                    loop: true,
                    nav: false,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayHoverPause: true,
                    dots: true,
                    stopOnHover: true,
                    animateOut: 'fadeOut'
                });

                $.get(
                    "= _A_::$app->router()->UrlTo('shop/widget_new_carousel');?>",
                    {},
                    function (data) {
                        $('#toko-carousel-871').html(data)
                            .owlCarousel({
                            responsive: {0: {items: 1}, 461: {items: 2}, 992: {items: 3}},
                            nav: true,
                            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                            autoplay: true,
                            autoplayHoverPause: false,
                            dots: true
                        });
                    }
                );
            }
        );
    })(jQuery);

</script>

<?php
include('views/product/block_footer.php');
?>

