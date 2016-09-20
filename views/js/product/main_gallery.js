'use strict';

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