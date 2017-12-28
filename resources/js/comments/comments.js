(function ($) {
  'use srtict';

  $('#modal').on('hidden.bs.modal', function () {
    $('#modal').find('.modal-footer').stop().show();
  });
})(window.jQuery || window.$);
