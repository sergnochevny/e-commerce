'use strict';
(function ($) {

  $("input").inputmask();
  $.danger_remove(8000);
  $.init_input();
  $(document).trigger('tiny_init');

})(jQuery);