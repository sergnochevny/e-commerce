(function ($) {
  'use strict';
  var wait_loader = '<div class="col-xs-12 text-center">' +
    '<i class="fa fa-spinner fa-pulse fa-4x"></i><br/>' +
    '</div>';
  $.each($('[data-load]'),
    function () {
      $(this).append(wait_loader);
    }
  );
  $.each($('[data-load]'),
    function () {
      $(this).parent('div').load($(this).attr('data-load'));
    }
  );
})(window.jQuery);
