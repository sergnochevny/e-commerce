'use strict';
var currentScript = document.currentScript || (function () {
  var scripts = document.getElementsByTagName('script');
  return scripts[scripts.length - 1];
})();
(function ($, me) {
  var wait_loader = '<div class="col-xs-12 text-center">' +
    '<i class="fa fa-spinner fa-pulse fa-4x"></i><br/>' +
    '</div>';
  $.each($(me).closest('div:not([data-load])').find('[data-load]'),
    function () {
      $(this).append(wait_loader);
    }
  );
  $.each($(me).closest('div:not([data-load])').find('[data-load]'),
    function () {
      $(this).parent().load($(this).attr('data-load') + '&url=' + encodeURI(btoa(window.location.pathname)));
    }
  );
})(jQuery, currentScript);