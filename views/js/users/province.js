'use strict';
(function ($) {

  $("[data-change-province]").on('change',
    function (event) {
      event.preventDefault();
      var url = $(this).parents('form').attr('action');
      var destination = $(this).attr('data-destination');
      var country = $(this).val();
      $('body').waitloader('show');
      $.get(
        url,
        {
          method: 'get_province_list',
          country: country
        },
        function (data) {
          $('select[name="' + destination + '"]').html(data);
          $('body').waitloader('remove');
        }
      )
    }
  );

})(jQuery);