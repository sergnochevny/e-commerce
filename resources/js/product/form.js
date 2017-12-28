(function ($) {

  $("input").inputmask();

  $.danger_remove(8000);

  if ($('[data-related] .product-item').length) {
    $('[data-carousel]').owlCarousel(
      {
        responsive: {0: {items: 1}, 520: {items: 2}, 820: {items: 3}, 990: {items: 4}},
        margin: 15,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        autoplay: true,
        loop: false,
        rewind: true,
        autoplayHoverPause: true,
        autoplayTimeout: 2000,
        dots: true
      }
    );
  }

  $('form#edit_form').init_input();

})(window.jQuery || window.$);