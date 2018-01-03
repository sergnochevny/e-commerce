var currentScript = document.currentScript || (function () {
  var scripts = document.getElementsByTagName('script');
  return scripts[scripts.length - 1];
})();
(function ($, me) {
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

  $.each($(me).closest('div:not([data-load])').find('[data-load]'),
    function () {
      $(this).append(wait_loader);
    }
  );

  $.each($(me).closest('div:not([data-load])').find('[data-load]'),
    function () {
      $(this).parent().load($(this).attr('data-load'),
        function () {
          InitTimeout();
        }
      );
    }
  );

})(jQuery, currentScript);
