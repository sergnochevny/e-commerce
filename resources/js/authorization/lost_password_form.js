'use strict';

(function ($) {

  $("input").inputmask();

  $.danger_remove(5000);

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

  $('body').init_input();

})(jQuery);