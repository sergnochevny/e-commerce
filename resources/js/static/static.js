(function ($) {
  $(document).ready(function (event) {
    setTimeout(function () {
      $('html,body').animate({
        scrollTop: $('#content').offset().top
      }, 2000);
    }, 300);
  });

  $('body').init_input();

})(jQuery);
