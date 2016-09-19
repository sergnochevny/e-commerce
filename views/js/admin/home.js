'use strict';

(function ($) {

    (function(){
        $(document).on('click.confirm_action', ".popup a.close",function () {
            $("#confirm_action").off('click.confirm_action');
            $("#confirm_dialog").removeClass('overlay_display');
        }).on('click.confirm_action', "#confirm_no",function () {
            $(".popup a.close").trigger('click');
        }).on('click', "#del_product",function (event) {
            event.preventDefault();
            var href = $(this).attr('href');

            $("#confirm_action").on('click.confirm_action',function (event) {
                event.preventDefault();
                $("#confirm_dialog").removeClass('overlay_display');
                window.location.href = href;
            });

            $("#confirm_dialog").addClass('overlay_display');
        });
    }).call(this);

})(jQuery);