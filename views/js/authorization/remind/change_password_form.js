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

  $('#psw_form').on('submit',
    function (event) {
      event.preventDefault();
      var data = new FormData(this);
      var url = $(this).attr('action');
      $.postdata(this, url, data, function (data) {
        $('#chng_pass').html(data);
      });
    }
  );

  $('#bchange').on('click',
    function (event) {
      event.preventDefault();
      $('#psw_form').trigger('submit');
    }
  );

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=password]').textinput();
  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);