(function ($) {

    $('#authorization').on('submit', function (event) {

        event.preventDefault();

        var msg = $(this).serialize(),
            url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: msg,
            success: function (data) {
                var results = $('.results');
                results.html(data);

                if (data.trim().length > 0) {
                    setTimeout(function () {
                        results.html('');
                    }, 3000);
                }
            },
            error: function (xhr, str) {
                alert('Error: ' + xhr.responseCode);
            }
        });
    });

    $('#blogin').on('click', function (event) {
        event.preventDefault();
        var action = $(this).attr('data-action');
        $('#authorization').attr('action', action).trigger('submit');
    });


})(jQuery);