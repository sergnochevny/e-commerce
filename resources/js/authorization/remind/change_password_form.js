(function ($) {
  'use srtict';

  $("input").inputmask();

  $.danger_remove(5000);

  $('#psw_form').init_input();

})(window.jQuery || window.$);