'use strict';
(function ($) {
    var danger = $('.danger');
    if (danger.length) {
        danger.css('display', 'block');

        setTimeout(function () {
            danger.css('display', 'none');
        }, 8000);
    }

    $("#edit_form").on('submit', function (event) {
        event.preventDefault();

        var url = $(this).attr('action'),
            data = new FormData(this);

        $('body').waitloader('show');
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                $.when($('#form_content').html(data)).done(function () {
                    $('body').waitloader('remove');
                });
            },
            error: function (xhr, str) {
                alert('Error: ' + xhr.responseCode);
                $('body').waitloader('remove');
            }
        });
    });
})(jQuery);