(function ($) {
  'use strict';
  var wait_loader = '<div class="col-xs-12 text-center">' +
    '<i class="fa fa-spinner fa-pulse fa-4x"></i><br/>' +
    '</div>';

  $.each($('[data-load-authorization]'),
    function () {
      $(this).append(wait_loader);
    }
  );
  $.each($('[data-load-authorization]'),
    function () {
      $(this).parent().load($(this).attr('data-load-authorization') + '&url=' + encodeURI(btoa(window.location.pathname)));
    }
  );
})(window.jQuery);
