'use strict';

(function ($) {

    (function(){

        $('#formx').on('submit',
            function(event){
                event.preventDefault();
                var msg = $(this).serialize(),
                    url = $(this).attr['action'];
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: msg,
                    success: function (data) {
                        $('.results').html(data);
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseCode);
                    }
                });
            }
        );

    }).call(this);

})(jQuery);