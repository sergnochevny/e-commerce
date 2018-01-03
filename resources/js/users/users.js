(function ($) {
  'use strict';

  $(document).on('change', "#edit_form [name=ship_as_billing]",
    function (event) {
      event.preventDefault();
      var destination = $(this).attr('aria-controls');
      var dest = $('#' + destination);
      if (dest.hasClass('in')) {
        dest.removeClass('in')
      } else {
        dest.addClass('in')
      }
    }
  );

})(window.jQuery || window.$);
