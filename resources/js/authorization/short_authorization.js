(function ($) {
  'use strict';

  $(document).on('submit', '#short_authorization',
    function (event) {
      event.preventDefault();
      var data = new FormData(this);
      var url = $(this).attr('action');
      var results = $(this).find('.results');
      $.postdata(this, url, data,
        function (data) {
          $('body').waitloader('show');
          $.when(results.html(data)).done(
            function () {
              if (results.children('script').length === 0) {
                $('body').waitloader('remove');
                setTimeout(function () {
                  results.html('');
                }, 5000);
              }
            }
          );
        }
      );
    }
  ).on('click', '#short_login',
    function (event) {
      event.preventDefault();
      var action = $(this).attr('href');
      $('#short_authorization').attr('action', action).trigger('submit');
    }
  );

})(window.jQuery || window.$);