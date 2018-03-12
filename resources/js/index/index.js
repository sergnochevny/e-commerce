(function ($) {
  'use strict';

  $(document).on('click', '[data-product]',
    function (event) {
      event.preventDefault();
      if ($(this).find(' > a').length) {
        $('body').waitloader('show');
        location.href = $(this).find(' > a').attr('href');
      }
    }
  ).on('click', '[data-product] > a',
    function (event) {
      event.stopPropagation();
    }
  ).ready(function () {
    $('.specials-products').owlCarousel({
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
      loop: false,
      rewind: true,
      autoplayHoverPause: true,
      autoplayTimeout: 2000,
      dots: true
    });
  });

})(window.jQuery || window.$);
