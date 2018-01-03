(function ($) {
  'use strict';
  $(document).ready(
    function (event) {
      setTimeout(function () {
        $('html, body').stop().animate({scrollTop: $('#blog').offset().top}, 2000);
      }, 300);
    }
  );
})(window.jQuery || window.$);
