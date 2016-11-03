'use strict';

(function ($) {

  $('#authorization').on('submit',
    function (event) {
      event.preventDefault();
      var msg = $(this).serialize(),
        url = $(this).attr['action'];
      $.ajax({
        type: 'POST',
        url: url,
        data: msg,
        success: function (data) {
          $('.results').html(data);
        },
        error: function (xhr) {
          alert('Error: ' + xhr.responseCode);
        }
      });
    }
  );

  $('#blogin').on('click',
    function (event) {
      event.preventDefault();
      var action = $(this).attr('data-action');
      $('#authorization').attr('action', action).trigger('submit');
    }
  );

})(jQuery);