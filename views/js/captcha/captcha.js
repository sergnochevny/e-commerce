'use strict';

(function ($) {

  $('#captcha_refresh').on('click',
    function (event) {
      event.preventDefault();
      if ($(this).is('[disabled]')) return false;
      var _this = this;
      $.when(
        $(_this).attr('disabled', 'disabled'),
        $(_this).find('.fa-refresh').addClass('fa-spin'),
        $('#captcha_img').attr('src', $('#captcha_img').attr('src'))
      ).done(
        function () {
          setTimeout(function () {
            $(_this).removeAttr('disabled');
            $(_this).find('.fa-spin').removeClass('fa-spin');
          }, 500);
        }
      );
    }
  );

})(jQuery);
