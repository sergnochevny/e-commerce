(function ($) {
  'use strict';

  $(document).on('submit', '#lost_password_form',
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

  $(document).on('click', '#blost', function (event) {
    event.preventDefault();
    $('#lost_password_form').trigger('submit');
  });

})(window.jQuery || window.$);