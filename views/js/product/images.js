'use strict';
(function($){
    $(document).on('click', 'a.pic_del_images',
        function (event) {
            event.preventDefault();
            var i_idx = $(this).attr('data-img_idx');

            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    event.preventDefault();
                    var url = $(this).parents('form').attr('action');
                    var data = {
                        method: 'del_pic',
                        idx: i_idx
                    }
                    $.get(
                        url,
                        data,
                        function(data){
                            $('#modify_images2').html(data);
                            $("#confirm_dialog").removeClass('overlay_display');
                            $("#confirm_action").off('click.confirm_action');
                        }
                    );
                }
            );

            $("#confirm_dialog").addClass('overlay_display');

        }
    );

    $(document).on('click', '.b_modify_images_pic_main_icon',
        function (event) {
            event.preventDefault();
            var i_idx = $(this).attr('data-img_idx');
            var data = {
                method: 'save_link',
                idx: i_idx
            };
            var url = $(this).parents('form').attr('action');
            $.get(
                url,
                data,
                function(data){
                    $('#modify_images2').html(data);
                }
            )
        }
    );

    $(document).on('click.confirm_action', ".popup a.close",
        function (event) {
            $("#confirm_action").off('click.confirm_action');
            $("#confirm_dialog").removeClass('overlay_display');
        }
    );

    $(document).on('click.confirm_action', "#confirm_no",
        function (event) {
            $(".popup a.close").trigger('click');
        }
    );

})(jQuery);
