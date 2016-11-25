'use strict';

(function ($) {

  $(":input").inputmask();

  $('#authorization').on('submit',
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

  $('#blogin').on('click',
    function (event) {
      event.preventDefault();
      var action = $(this).attr('href');
      $('#authorization').attr('action', action).trigger('submit');
    }
  );

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();
  $('input[type=email]').textinput();
  $('input[type=password]').textinput();

  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);