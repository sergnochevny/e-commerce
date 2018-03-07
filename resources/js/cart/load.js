(function ($) {
  'use strict';
  var wait_loader = '<div class="col-xs-12 text-center">' +
    '<i class="fa fa-spinner fa-pulse fa-4x"></i><br/>' +
    '</div>';

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

  $.each($('[data-load-cart]'),
    function () {
      $(this).append(wait_loader);
    }
  );

  $.each($('[data-load-cart]'),
    function () {
      $(this).parent().load($(this).attr('data-load-cart'),
        function () {
          InitTimeout();
        }
      );
    }
  );

})(window.jQuery);
