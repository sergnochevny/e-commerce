'use strict';
(function ($) {
    $(document).ready(function () {

        $('.best-products').load($('#slider_url').val());

        $.get($('#get_url').val(), {}, function (data) {
            $('.special-products').html(data).owlCarousel({
                responsive: {0: {items: 1}, 461: {items: 2}, 992: {items: 3}},
                nav: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                autoplay: true,
                loop: true,
                autoplayHoverPause: false,
                dots: true
            });
        });
    });
})(jQuery);