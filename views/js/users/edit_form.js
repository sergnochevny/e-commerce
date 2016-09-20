'use strict';
(function($){

    var base_url = $('#base_url').val(),
        danger = $('.danger'),
        userForm = $("#edit_user_form"),
        userFormCountry = $("#edit_user_form [name=country]");

    if (danger.length>0){
        danger.css('display', 'block');
        $('html, body').stop().animate({scrollTop: parseInt(danger.offset().top) - 250 }, 1000);
        setTimeout(function () {
            $('.danger').css('display', 'none');
        }, 8000);
    }

    userForm.on('submit',
        function(event){
            event.preventDefault();
            var url = $(this).attr('action');
            $.post(
                url,
                $(this).serialize(),
                function(data){
                    $("#user_form").html(data);
                }
            )
        }
    );

    userFormCountry.on('change',
        function (event) {
            event.preventDefault();
            var url = base_url + 'users/get_province_list';
            var country = $(this).val();
            $.get(
                url,
                {country: country},
                function (data) {
                    $('select[name=province]').html(data);
                }
            )
        }
    );

    userFormCountry.on('change',
        function (event) {
            event.preventDefault();
            var url = base_url + 'users/get_province_list';
            var country = $(this).val();
            $.get(
                url,
                {country: country},
                function (data) {
                    $('select[name=s_state]').html(data);
                }
            )
        }
    );

})(jQuery);