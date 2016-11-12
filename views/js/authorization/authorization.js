'use strict';

(function ($) {

  $('#authorization').on('submit',
    function (event) {
      event.preventDefault();
      var data = new FormData(this);
      var url = $(this).attr('action');
      $.postdata(this, url, data,
        function (data) {
          var results = $('.results');
          $.when(results.html(data)).done(function () {
            debugger;
            if (results.children('script').length == 0) {
              setTimeout(function () {
                results.html('');
              }, 3000);
            } else {
              $('body').waitloader('show');
            }
          });
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
  $('input[type=password]').textinput();
  $('input[type=textarea]').textinput();
  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);