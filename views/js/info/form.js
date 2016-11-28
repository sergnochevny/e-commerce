'use strict';
(function ($) {

  $("input").inputmask();

  $.danger_remove(8000);

  $('input[type=text]').textinput();
  $('input[type=number]').textinput();
  $('input[type=email]').textinput();
  $('input[type=password]').textinput();

  $('select').selectmenu();

  $(document).trigger('tiny_init');

})(jQuery);