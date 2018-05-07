(function ($) {
  'use strict';

  $(document).on('click', '#captcha_refresh',
    function (event) {
      debugger;
      event.preventDefault();
      if ($(this).is('[disabled]')) return false;
      var _this = this;
      $(_this).attr('disabled', 'disabled');
      $(_this).find('.fa-refresh').addClass('fa-spin');
      var url = $(_this).attr('href');
      $.ajax({
        url: url,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
          debugger;
          $('#captcha_img').attr('src', data);
          setTimeout(function () {
            $(_this).removeAttr('disabled');
            $(_this).find('.fa-spin').removeClass('fa-spin');
          }, 500);
        },
        error: function (xhr, str) {
          $(_this).removeAttr('disabled');
          $(_this).find('.fa-spin').removeClass('fa-spin');
        }
      });
      return false;
    }
  );

})(window.jQuery || window.$);
