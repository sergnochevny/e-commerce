'use strict';

(function ($) {
  $(document).ready(
    function (event) {
      setTimeout(function () {
        $('html, body').stop().animate({
          scrollTop: $('#content').offset().top
        }, 2000);
      }, 300);
    }
  );
})(jQuery);