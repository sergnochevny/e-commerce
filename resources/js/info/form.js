'use strict';
(function ($) {

  $("input").inputmask();
  $.danger_remove(8000);
  $('body').init_input();
  $(document).trigger('tiny_init');

})(jQuery);