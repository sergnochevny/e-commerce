(function ($) {
  'use strict';

  $("input[data-inputmask]").inputmask();

  $('#short_authorization').init_input();
  $('#short_authorization').init_checkbox();

})(window.jQuery || window.$);