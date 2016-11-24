(function ($) {

  $.each($('[data-load]'),
    function () {
      $(this).load($(this).attr('data-load'));
    }
  );

})(jQuery);