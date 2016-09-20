'use strict';


(function ($) {
    $(document).ready(
        function (event) {

            $('#toko-carousel-560').load($('#slider_url').val());

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

            $.get( $('#get_url').val(), {}, function (data) {
                    $('#toko-carousel-871').html(data).owlCarousel({
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