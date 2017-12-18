'use strict';

(function ($) {

  $(document).on('click', ".overlay", function (event) {
    $(this).removeClass('overlay_display');
  }).on('click', 'i[data-promotion]', function (event) {
    event.preventDefault();
    var target = $(this).attr('href');
    $("div" + target).addClass('overlay_display');
  });

})(jQuery);
