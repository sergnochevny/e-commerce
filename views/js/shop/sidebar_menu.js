'use strict';
(function ($) {
  $(document).on('click', '[data-sb_prices]',
    function (event) {
      event.preventDefault();
      var url = $(this).attr('href');
      var data = new FormData();
      data.append('search[hidden][a.priceyard][from]', $(this).attr('data-prices_from'));
      data.append('search[hidden][a.priceyard][to]', $(this).attr('data-prices_to'));
      $.postdata(this, url, data,
        function (data) {
          $.when($('#content').html(data)).done(function () {
            $('.shop__sidebar').animate({top: 138});
          });
        }
      );
    }
  );

  $(document).on('click', '[data-sb]',
    function (event) {
      event.preventDefault();
      var url = $(this).attr('href');
      var data = new FormData();
      $.postdata(this, url, data,
        function (data) {
          $.when($('#content').html(data)).done(function () {
            $('.shop__sidebar').animate({top: 138});
          });
        }
      );
    }
  );

})(jQuery);