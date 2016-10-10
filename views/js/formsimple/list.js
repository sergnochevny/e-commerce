'use strict';

(function ($) {

    var danger = $('.danger');
    if (danger.length) {
        danger.css('display', 'block');
        $('html, body').stop().animate({scrollTop: parseInt(danger.offset().top) - 250}, 1000);
        setTimeout(function () {
            $('.danger').css('display', 'none');
        }, 8000);
    }

})(jQuery);