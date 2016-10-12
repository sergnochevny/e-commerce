<div class="site-container">
    <?php
    include "views/header.php";
    include('views/index/main_gallery.php');
    ?>

    <!--Slider-->
    <link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/owl.carousel.css'); ?>' type='text/css' media='all'/>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/owl.carousel.min.js'); ?>'></script>

    <div class="main-content" id="newsletter-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="page type-page status-publish entry">
                        <div class="entry-content">
                            <div class="vc_row wpb_row vc_row-fluid vc_custom_1439733758005">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="just-divider text-left line-no icon-hide">
                                            <div class="divider-inner" style="background-color: #fff">
                                                <h3 class="just-section-title">Newsletter</h3>

                                                <p class="paragraf">DESIGNER UPHOLSTERY/ DRAPERY FABRIC SUPERSALE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p><a href="index">Fabrics start at $10.00 / yard. PLUS FREE SHIPPING.* Click to shop.</a>
                            </p>

                            <p>*(Free Ground Shipping in the Contiguous United States Only. Faster Shipping available at
                                moderate rates, Worldwide, if necessary)</p><br/><br/>

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

                    $('.just-slider-active').owlCarousel({
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

                    setTimeout(function () {
                        $('html,body').stop().animate({
                            scrollTop: $('#newsletter-page').offset().top
                        }, 2000);
                    }, 300);
                }
            );
        })(jQuery);

    </script>

    <?php
    include('views/product/block_footer.php');
    ?>