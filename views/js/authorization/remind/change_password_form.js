'use strict';

(function ($) {

    $('#psw_form').on('submit',
        function (event) {
            event.preventDefault();
            var msg = $(this).serialize(),
                url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: msg,
                success: function (data) {
                    $.when($('#chng_pass').html(data)).done(function () {
                        if ($('.danger').length) {
                            setTimeout(function () {
                                $('.danger').remove();
                            }, 8000);
                        }
                    });
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseCode);
                }
            });
        }
    );

    $('#bchange').on('click',
        function (event) {
            event.preventDefault();
            $('#psw_form').trigger('submit');
        }
    );


})(jQuery);