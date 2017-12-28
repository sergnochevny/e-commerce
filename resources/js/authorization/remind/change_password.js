(function ($) {
  'use srtict';

  $(document).on('submit', '#psw_form',
    function (event) {
      event.preventDefault();
      var data = new FormData(this);
      var url = $(this).attr('action');
      $.postdata(this, url, data, function (data) {
        $('#chng_pass').html(data);
      });
    }
  );

  $(document).on('click', '#bchange',
    function (event) {
      event.preventDefault();
      $('#psw_form').trigger('submit');
    }
  );


})(window.jQuery || window.$);