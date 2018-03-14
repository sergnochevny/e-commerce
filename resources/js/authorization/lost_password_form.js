(function ($) {
  'use strict';

  $("input[data-inputmask]").inputmask();

  $.danger_remove(5000);

  $('body').init_input();

})(window.jQuery || window.$);