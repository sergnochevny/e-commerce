'use strict';

(function ($) {

  if ($('.danger').length) {
    $('.danger').stop().show();
    setTimeout(
      function () {
        $('.danger').remove();
      }
      , 5000
    );
  }

  $('#lost_password_form').on('submit',
    function (event) {
      event.preventDefault();
      var data = new FormData(this);
      var url = $(this).attr('action');
      $.postdata(this, url, data, function (data) {
          $('#lost_password_container').html(data);
        }
      );
    }
  );

  $('#blost').on('click', function (event) {
    event.preventDefault();
    $('#lost_password_form').trigger('submit');
  });

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=password]').textinput();
  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);