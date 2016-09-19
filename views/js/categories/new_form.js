'use strict';
(function($){
    $("#new_category_form").on('submit',
        function (event) {
            event.preventDefault();
            var url = $(this).attr('action');
            throwDanger(url, $(this).serialize(), $("#category_form"));
        }
    );
})(jQuery);