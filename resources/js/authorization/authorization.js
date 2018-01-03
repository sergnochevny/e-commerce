(function ($) {
  'use strict';

  $(document).on('submit', '#authorization',
    function (event) {
      event.preventDefault();
      var data = new FormData(this);
      var url = $(this).attr('action');
      var results = $(this).find('.results');
      $.postdata(this, url, data,
        function (data) {
          $.when(results.html(data)).done(
            function () {
              if (results.children('script').length === 0) {
                setTimeout(function () {
                  results.html('');
                }, 5000);
              }
            }
          );
        }
      );
    }
  ).on('click', '#login',
    function (event) {
      event.preventDefault();
      var action = $(this).attr('href');
      $('#authorization').attr('action', action).trigger('submit');
    }
  );

})(window.jQuery || window.$);