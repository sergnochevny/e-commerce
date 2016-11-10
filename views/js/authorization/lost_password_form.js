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
      var msg = $(this).serialize(),
        url = $(this).attr('action');
      $.ajax({
        type: 'POST',
        url: url,
        data: msg,
        success: function (data) {
          $('#lost_password_container').html(data);
        },
        error: function (xhr, str) {
          alert('Error: ' + xhr.responseCode);
        }
      });
    }
  );

  $('#blost').on('click', function (event) {
    event.preventDefault();
    $('#lost_password_form').trigger('submit');
  });


})(jQuery);