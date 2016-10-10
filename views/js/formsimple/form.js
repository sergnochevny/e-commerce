'use strict';
(function ($) {
    var danger = $('.danger');
    if (danger.length) {
        danger.css('display', 'block');
        $('html, body').stop().animate({
                scrollTop: parseInt(danger.offset().top) - 250
            }, 1000
        );

        setTimeout(function () {
            danger.css('display', 'none');
        }, 8000);
    }

    $("#edit_form").on('submit', function (event) {
        event.preventDefault();
        var url = $(this).attr('action');
        var data = new FormData(this);
        $.post(
            url,
            data,
            function (data) {
                $("#category_form").html(data);
            }
        );
    });
})(jQuery);