'use strict';
(function ($) {
  var base_url = $('#base_url').val();

  $(document).off('.basket');

  $(document).on('click', '.shop__sidebar-list a[data-index]',
    function (event) {
      $('.shop__sidebar-list .active').removeClass('active');
      $(this).addClass('active');
    }
  );

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

})(jQuery);