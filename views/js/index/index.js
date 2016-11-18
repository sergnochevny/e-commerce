'use strict';
(function ($) {
  $(document).ready(function () {

    $('.best-products').load($('#slider_url').val());

    $.get($('#get_url').val(), {}, function (data) {
      $('.special-products').html(data).owlCarousel({
        responsive: {0: {items: 1}, 461: {items: 2}, 992: {items: 3}},
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
    function(event){
      event.preventDefault();
      if($(this).find(' > a').length){
        $('body').waitloader('show');
        location.href = $(this).find(' > a').attr('href');
      }
    }
  );

  $(document).on('click', '[data-product] > a', function(event){event.stopPropagation();});


  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();
  $('input[type=password]').textinput();
  $('input[type=email]').textinput();

})(jQuery);