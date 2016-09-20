'use strict';

(function($){
    $("#blog_category_form").on('submit',
        function(event){
            event.preventDefault();
            var url = $(this).attr('action');
            $.post(
                url,
                $(this).serialize(),
                function(data){
                    var danger = $('.danger');
                    $("#category_form").html(data);
                    danger.css('display','block');
                    $('html, body').stop().animate({scrollTop: parseInt(danger.offset().top) - 250 }, 1000);
                    setTimeout(function(){
                        $('.danger').css('display','none');
                    },8000);
                }
            )

        }
    );
})(jQuery);