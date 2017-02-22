'use strict';

(function ($) {

  $("input").inputmask();

  $("#edit_form [name=ship_as_billing]").on('change',
    function (event) {
      var destination = $(this).attr('aria-controls');
      var dest = $('#' + destination);
      if (dest.hasClass('in')) {
            dest.removeClass('in')
      } else {
            dest.addClass('in')
        }
    }
  );

})(jQuery);
