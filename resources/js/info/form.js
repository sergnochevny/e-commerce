(function ($) {
  'use strict';

  $("input").inputmask();
  $.danger_remove(8000);
  $('body').init_input();
  $(document).trigger('tiny_init');

})(window.jQuery || window.$);