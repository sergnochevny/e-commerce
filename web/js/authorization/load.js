'use strict';
var currentScript = document.currentScript || (function () {
    var scripts = document.getElementsByTagName('script');
    return scripts[scripts.length - 1];
  })();
(function ($, me) {

  $.each($(me).closest('div:not([data-load])').find('[data-load]'),
    function () {
      $(this).parent().load($(this).attr('data-load') + '&url=' + encodeURI(btoa(window.location.pathname)));
    }
  );

})(jQuery, currentScript);
