'use strict';
(function($){
    $(document).on('click.confirm_action', ".popup a.close",
        function (event) {
            $("#confirm_action").off('click.confirm_action');
            $("#confirm_dialog").removeClass('overlay_display');
        }
    ).on('click.confirm_action', "#confirm_no",
        function (event) {
            $(".popup a.close").trigger('click');
        }
    ).on('click', 'a#del_discount',
        function (event) {
            event.preventDefault();
            var href = $(this).attr('href');

            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    var body = $('body');
                    event.preventDefault();
                    body.waitloader('show');
                    $('#content').load(href);
                    body.waitloader('remove');
                    $("#confirm_dialog").removeClass('overlay_display');
                    $("#confirm_action").off('click.confirm_action');
                }
            );

            $("#confirm_dialog").addClass('overlay_display');

        }
    );
})(jQuery);