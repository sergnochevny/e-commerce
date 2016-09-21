'use strict';
(function($){
    $(document).on('click.confirm_action', ".popup a.close",function (event) {
        $("#confirm_action").off('click.confirm_action');
        $("#confirm_dialog").removeClass('overlay_display');
    });

    $(document).on('click.confirm_action', "#confirm_no", function (event) {
        $(".popup a.close").trigger('click');
    });

    $(document).on('click', 'a#del_blog_category',
        function (event) {
            event.preventDefault();
            var href = $(this).attr('href');
            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    event.preventDefault();
                    $.get(
                        href,
                        {},
                        function(data){

                            $('#content').html(data);
                            $("#confirm_dialog").removeClass('overlay_display');
                            $("#confirm_action").off('click.confirm_action');
                            if($('.danger').length){
                                $('html, body').stop().animate({
                                    scrollTop: parseInt($('.danger').offset().top) - 250
                                }, 1000);

                                setTimeout(function(){
                                    $('.danger').remove();
                                },8000);
                            }
                        }
                    );
                }
            );

            $("#confirm_dialog").addClass('overlay_display');

        }
    );
})(jQuery);