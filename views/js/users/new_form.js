'use strict';
(function($){

    var base_url = $('#base_url').val(),
        danger = $('.danger');

    if (danger.length>0){
        danger.css('display', 'block');
        $('html, body').stop().animate({scrollTop: parseInt(danger.offset().top) - 250 }, 1000);
        setTimeout(function () {
            $('.danger').css('display', 'none');
        }, 8000);
    }

    $("#new_user_form").on('submit',
        function (event) {
            event.preventDefault();
            var url = $(this).attr('action');
            $('#content').waitloader('show');
            $.post(
                url,
                $(this).serialize(),
                function (data) {
                    $("#user_form").html(data);
                    $('#content').waitloader('remove');
                }
            )
        }
    );

    $("#new_user_form [name=country]").on('change',
        function (event) {
            event.preventDefault();
            var url = base_url + 'users/get_province_list';
            var country = $(this).val();
            $('#content').waitloader('show');
            $.get(
                url,
                {country: country},
                function (data) {
                    $('select[name=province]').html(data);
                    $('#content').waitloader('remove');
                }
            )
        }
    );

    $("#new_user_form [name=s_country]").on('change',
        function (event) {
            event.preventDefault();
            var url = base_url + 'users/get_province_list';
            var country = $(this).val();
            $('#content').waitloader('show');
            $.get(
                url,
                {country: country},
                function (data) {
                    $('select[name=s_state]').html(data);
                    $('#content').waitloader('remove');
                }
            )
        }
    );

})(jQuery);