'use strict';

(function ($) {
    $('#modal').on('hidden.bs.modal', function () {
        $('#modal').find('.modal-footer').stop().show();
    });
})(jQuery);