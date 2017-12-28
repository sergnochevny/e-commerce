(function ($) {
  'use srtict';

  $("input").inputmask();

  $.danger_remove(8000);

  $('form#edit_form').init_input();

})(window.jQuery || window.$);
