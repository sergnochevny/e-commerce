(function ($) {
  'use srtict';

  $("input").inputmask();

  $('#modal-title').html($('#edit_form').attr('data-title'));
  $('#modal').modal('show');

  $('form#edit_form').init_input();

})(window.jQuery || window.$);
