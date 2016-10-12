'use strict';


(function ($) {
    $(document).ready(
        function (event) {

            $('#just-carousel-560').load($('#slider_url').val());

            $.get( $('#get_url').val(), {}, function (data) {
                    $('#just-carousel-871').html(data).owlCarousel({
                        responsive: {0: {items: 1}, 461: {items: 2}, 992: {items: 3}},
                        nav: true,
                        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                        autoplay: true,
                        loop: true,
                        autoplayHoverPause: false,
                        dots: true
                    });
                }
            );
        }
    );
})(jQuery);