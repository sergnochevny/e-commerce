(function ($) {
  'use strict';

  $("input[data-inputmask]").inputmask();

  $('#modal-title').html($('#edit_form').attr('data-title'));
  $('#modal').modal('show');

  $('form#edit_form').init_input();

})(window.jQuery || window.$);
