<!--Slider-->
<link rel='stylesheet' href='= _A_::$app->router()->UrlTo('views/css/owl.carousel.css'); ?>' type='text/css' media='all'/>
<script type='text/javascript' src='= _A_::$app->router()->UrlTo('views/js/owl.carousel.min.js'); ?>'></script>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <article class="page type-page status-publish entry">
                    <div class="entry-content">
                        <div data-vc-full-width="true" data-vc-full-width-init="false" data-vc-stretch-content="true"
                             class="vc_row wpb_row vc_row-fluid vc_custom_1439536789991 vc_row-no-padding">
                            <div class="wpb_column vc_column_container">
                                <div class="wpb_wrapper">
                                    <div class="toko-slider-wrap">
                                        <div class="toko-slides toko-slider-active owl-carousel owl-theme owl-loaded">
                                            <div class="toko-slide"
                                                 style="background-image:url(= _A_::$app->router()->UrlTo('views/images/slider/slide1.jpg');?>);background-size:cover;background-position:center right;background-repeat:no-repeat;">
                                                <div class="toko-slide-inner">
                                                    <div class="toko-slide-detail">
                                                        <p class="toko-slide-desc">Featured Fabric Selection</p>

                                                        <h2 class="toko-slide-title">View our Fabrics</h2>
                                                        <a class="toko-slide-button" href="shop">Shop Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="toko-slide"
                                                 style="background-image:url(= _A_::$app->router()->UrlTo('views/images/slider/slide2.jpg');?>);background-size:cover;background-position:center right;background-repeat:no-repeat;">
                                                <div class="toko-slide-inner">
                                                    <div class="toko-slide-detail">
                                                        <p class="toko-slide-desc">Featured Fabric Selection</p>

                                                        <h2 class="toko-slide-title">View our Fabrics</h2>
                                                        <a class="toko-slide-button" href="shop">Shop Now</a>
                                                    </div>
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
<script type="text/javascript">

    (function ($) {
        $(document).ready(
            function (event) {

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

            }
        );
    })(jQuery);

</script>

