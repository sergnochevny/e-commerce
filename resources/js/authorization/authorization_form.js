(function ($) {
  'use strict';

  $("input[data-inputmask]").inputmask();

  $('#authorization').init_input();
  $('#authorization').init_checkbox();

})(window.jQuery || window.$);