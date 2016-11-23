'use strict';
(function ($) {

  var danger = $('.danger');
  if (danger.length) {
    danger.css('display', 'block');
    setTimeout(function () {
      danger.css('display', 'none');
    }, 8000);
  }

  $('input[type=text]').textinput();
  $('input[type=number]').textinput();
  $('input[type=email]').textinput();
  $('input[type=password]').textinput();

  $('select').selectmenu();

  $(document).trigger('tiny_init');

})(jQuery);