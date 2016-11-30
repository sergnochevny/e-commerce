(function ($) {
  $(document).ready(function (event) {
    setTimeout(function () {
      $('html,body').animate({
        scrollTop: $('#content').offset().top
      }, 2000);
    }, 300);
  });

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();
  $('input[type=password]').textinput();
  $('input[type=email]').textinput();

  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);
