'use strict';

(function ($) {

  $("input").inputmask();

  $.danger_remove(5000);

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

  $('#psw_form').init_input();

})(jQuery);