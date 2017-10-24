'use strict';

(function ($) {
  $(document).ready(function () {
    $.get($('#specials-products_url').val(), {}, function (data) {
      $('.specials-products').html(data).owlCarousel({
        responsive: {
          0: {items: 1},
          461: {items: 2},
          992: {items: 3},
          1200: {items: 4}
        },
        margin: 15,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        autoplay: true,
        loop: true,
        autoplayHoverPause: false,
        dots: true
      });
    });
  });

  $(document).on('click', '[data-product]',
    function (event) {
      event.preventDefault();
      if ($(this).find(' > a').length) {
        $('body').waitloader('show');
        location.href = $(this).find(' > a').attr('href');
      }
    }
  );

  $(document).on('click', '[data-product] > a',
    function (event) {
      event.stopPropagation();
    }
  );

})(jQuery);
