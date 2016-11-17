'use strict';
(function ($) {
  $(document).on('click', '[data-prices]',
    function(event){
      event.stopPropagation();
      var url = $(this).attr('href');
      var data = new FormData();
    }
  );

})(jQuery);