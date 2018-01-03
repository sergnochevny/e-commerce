(function ($) {
  'use strict';

  var base_url = $('#base_url').val();

  $(document).off('.basket').on('click', '.shop__sidebar-list a[data-index]',
    function (event) {
      $('.shop__sidebar-list .active').removeClass('active');
      $(this).addClass('active');
    }
  ).on('click', '[data-product]',
    function (event) {
      event.preventDefault();
      if ($(this).find(' > a').length) {
        $('body').waitloader('show');
        location.href = $(this).find(' > a').attr('href');
      }
    }
  ).on('click', '[data-product] > a', function (event) {
    event.stopPropagation();
  });

})(window.jQuery || window.$);