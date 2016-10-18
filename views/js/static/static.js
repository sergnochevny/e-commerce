(function ($) {
    $(document).ready(function (event) {
        setTimeout(function () {
            $('html,body').animate({
                scrollTop: $('#static').offset().top
            }, 2000);
        }, 300);
    });
})(jQuery);
