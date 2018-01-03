(function ($) {
  'use strict';

  $(document).on('click', ".overlay", function (event) {
    event.preventDefault();
    $(this).removeClass('overlay_display');
  }).on('click', 'i[data-promotion]', function (event) {
    event.preventDefault();
    var target = $(this).attr('href');
    $("div" + target).addClass('overlay_display');
  });

})(window.jQuery || window.$);
