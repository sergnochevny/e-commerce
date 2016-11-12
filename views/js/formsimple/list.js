'use strict';
(function ($) {

  var danger = $('.danger');
  if (danger.length) {
    danger.css('display', 'block');
    setTimeout(function () {
      $('.danger').css('display', 'none');
    }, 8000);
  }

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();

  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);