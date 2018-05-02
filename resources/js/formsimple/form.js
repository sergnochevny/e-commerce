(function ($) {
  'use strict';
  debugger;
  $("input[data-inputmask]").inputmask();

  $.danger_remove(8000);

  $("form#edit_form").init_input();

})(window.jQuery || window.$);
