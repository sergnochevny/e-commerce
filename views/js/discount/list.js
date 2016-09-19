'use strict';
(function ($) {
    $('a').on('click', function (event) {
        $('body').waitloader('show');
    });
})(jQuery);