'use strict';
(function($){
    $(document).on('click', 'a.pic_del_images',
        function (event) {
            event.preventDefault();
            var p_id = $(this).attr('href');
            var i_idx = $(this).attr('data-img_idx');

            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    event.preventDefault();
                    $.get(
                        'del_pic?p_id=' + p_id + '&idx=' + i_idx,
                        {},
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
            var p_id = $(this).attr('data-p_id');
            var i_idx = $(this).attr('data-img_idx');
            var url = $('#save_link').val()+"?p_id=" + p_id + "&idx=" + i_idx;
            $.get(
                url,
                {},
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
