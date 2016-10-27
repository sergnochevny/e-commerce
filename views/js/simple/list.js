'use strict';

(function ($) {

    var danger = $('.danger');
    if (danger.length) {
        danger.css('display', 'block');
        setTimeout(function () {
            $('.danger').css('display', 'none');
        }, 8000);
    }

    $('#modal').on('hidden.bs.modal', function () {
        $(this).find('#modal_content').empty();
    });

    $('[data-modify]').on('click', function (event) {
        event.preventDefault();
        if (!$(this).is('.disabled')) {
            var url = $(this).attr('href');
            $('body').waitloader('show');
            $.when(
                $('#modal_content').load(url)
            ).done(function () {
                $('body').waitloader('remove');
            });
        }
    });

    $('[data-view]').on('click', function (event) {
        event = event || window.event;
        event.preventDefault();

        $('body').waitloader('show');
        var url = $(this).attr('href');

        $.when(
            $('#modal_content').load(url)
        ).done(function () {
            $('body').waitloader('remove');
        });
    });

})(jQuery);