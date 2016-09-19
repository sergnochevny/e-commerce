'use strict';

(function($){
    $("#category_edit_form").on('submit',
        function(event){
            event.preventDefault();
            var url = $(this).attr('action');
            throwDanger(url, $(this).serialize(), $("#category_form"))
        }
    );
})(jQuery);