(function ($) {
  'use strict';

  $(document).on('change', "[data-change-province]",
    function (event) {
      event.preventDefault();
      var url = $(this).parents('form').attr('action');
      var destination = $(this).attr('data-destination');
      var country = $(this).val();
      $('body').waitloader('show');
      $.post(
        url,
        {
          method: 'get_province_list',
          country: country
        },
        function (data) {
          $('select[name="' + destination + '"]').html(data);
          if ($('select[name="' + destination + '"]').selectmenu && $('select[name="' + destination + '"]').selectmenu('instance'))
            $('select[name="' + destination + '"]').selectmenu('refresh');
          $('body').waitloader('remove');
        }
      )
    }
  );

})(window.jQuery || window.$);
