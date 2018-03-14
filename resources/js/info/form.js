(function ($) {
  'use strict';

  $("input[data-inputmask]").inputmask();
  $.danger_remove(8000);
  $('body').init_input();
  $(document).trigger('tiny_init');

})(window.jQuery || window.$);