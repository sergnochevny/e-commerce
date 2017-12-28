(function ($) {
  'use strict';

  $("input").inputmask();

  $.danger_remove(5000);

  $('body').init_input();

})(window.jQuery || window.$);