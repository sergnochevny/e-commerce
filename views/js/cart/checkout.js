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

  $('[data-load]').load($('[data-load]').attr('data-load'),
    function () {
      InitTimeout();
    }
  );
})(jQuery);