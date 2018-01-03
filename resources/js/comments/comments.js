(function ($) {
  'use strict';

  $(document).on('hidden.bs.modal', '#modal', function () {
    $('#modal').find('.modal-footer').stop().show();
  });
})(window.jQuery || window.$);
