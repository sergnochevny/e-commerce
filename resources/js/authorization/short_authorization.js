'use strict';

(function ($) {

  $("input").inputmask();

  $('#short_authorization').on('submit',
    function (event) {
      event.preventDefault();
      var data = new FormData(this);
      var url = $(this).attr('action');
      var results = $('.results');
      $.postdata(this, url, data,
        function (data) {
          $.when(results.html(data)).done(
            function () {
              if (results.children('script').length == 0) {
                setTimeout(function () {
                  results.html('');
                }, 3000);
              }
            }
          );
        }
      );
    }
  );

  $('#short_login').on('click',
    function (event) {
      event.preventDefault();
      var action = $(this).attr('href');
      $('#short_authorization').attr('action', action).trigger('submit');
    }
  );

  $('#short_authorization').init_input();

})(jQuery);