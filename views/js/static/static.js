(function ($) {
  $(document).ready(function (event) {
    setTimeout(function () {
      $('html,body').animate({
        scrollTop: $('#static').offset().top
      }, 2000);
    }, 300);
  });

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();

  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);
