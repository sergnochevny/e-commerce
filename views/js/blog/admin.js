'use strict';

(function ($) {

    $(document).on('click.confirm_action', ".popup a.close",function (e) {
        $("#confirm_action").off('click.confirm_action');
        $("#confirm_dialog").removeClass('overlay_display');
    }).on('click.confirm_action', "#confirm_no", function (e) {
        $(".popup a.close").trigger('click');
    }).on('click', "#del_post",
        function (event) {
            event.preventDefault();

            var href = $(this).attr('href');

            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    event.preventDefault();
                    $.get(href,{},function(data){
                        $('#content').html(data);
                        $("#confirm_dialog").removeClass('overlay_display');
                        $("#confirm_action").off('click.confirm_action');
                        $('html, body').stop().animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
                        setTimeout(function(){
                            $('.danger').remove();
                        },8000);
                    });
                }
            );

            $("#confirm_dialog").addClass('overlay_display');
        }
    );
})(jQuery);