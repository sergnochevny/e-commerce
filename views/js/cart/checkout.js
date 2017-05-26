(function ($) {

  function InitTimeout() {
    var timeout = $('[data-timeout]').attr('data-timeout') * 1000 * 60;
    setTimeout(function () {
      if ($('#modal').length > 0) {
        $('#modal').on('hidden.bs.modal',
          function () {
            InitTimeout();
          }
        );
        $('#modal').modal('show');
      }
    }, timeout);
  }

  $.each($('[data-load]'),
    function () {
      $(this).load($(this).attr('data-load'),
        function () {
          InitTimeout();
        }
      );
    }
  );

  $.danger_remove(8000);

})(jQuery);
