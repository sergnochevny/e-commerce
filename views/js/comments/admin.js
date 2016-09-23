'use strict';
(function($){
    $(document).on('click.confirm_action', ".popup a.close",
        function (event) {
            $("#confirm_action").off('click.confirm_action');
            $("#confirm_dialog").removeClass('overlay_display');
        }
    ).on('click.confirm_action', "#confirm_no",function (event) {
        $(".popup a.close").trigger('click');
    }).on('click', 'a.del_user',
        function (event) {
            event.preventDefault();
            var href = $(this).attr('href');
            $("#dialog-text").html("You confirm the removal?");

            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    event.preventDefault();
                    $('#content').load(href);
                    $("#confirm_dialog").removeClass('overlay_display');
                    $("#confirm_action").off('click.confirm_action');
                }
            );

            $("#confirm_dialog").addClass('overlay_display');

        }
    ).on('click', 'a.public_comment',
        function (event) {
            event.preventDefault();
            var href = $(this).attr('href'),
                mode = "",
                a1 = $(this).attr("value");

            $("#dialog-text").html((a1 == "1") ?"Hide comment?" : "Show comment?");

            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    event.preventDefault();
                    $('#content').load(href);
                    $("#confirm_dialog").removeClass('overlay_display');
                    $("#confirm_action").off('click.confirm_action');
                }
            );
            $("#confirm_dialog").addClass('overlay_display');
        }
    );
    $(document).on('click', 'a.view-comment',
        function (event) {
            event.preventDefault();
            var href = $(this).attr('href');

            $.get(href, function(data){
                $("#comment-view-dialog-data").html(data);
            });

            $(".close").on('click.close', function (event){
                event.preventDefault();
                $("#comment-view-dialog").removeClass('overlay_display');
            });

            $("#comment-view-dialog").addClass('overlay_display');
        }
    );
    $(document).on('click', 'a.edit-comment',
        function (event) {
            event.preventDefault();
            var href = $(this).attr('href'),
                href_update = $('#href_update_comment').val();

            $.get(href, function(data){
                $("#comment-view-dialog-data").html(data);
                $("#add-form-send").bind("click", function(){
                    $('#content').load(href_update);
                });
            });

            $(".close").on('click.close',function (event){
                event.preventDefault();
                $('#content').load(href_update);
                $("#comment-view-dialog").removeClass('overlay_display');
            });
            $("#comment-view-dialog").addClass('overlay_display');
        }
    );


})(jQuery);