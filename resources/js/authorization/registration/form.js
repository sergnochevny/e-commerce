'use strict';

(function ($) {
  $("input").inputmask();

  $("form#edit_form").on('submit', function (event) {
    event.preventDefault();
    var url = $(this).attr('action');
    var data = new FormData(this);
    var container = $(this).parents('[data-role=form_content]');
    if (container.length == 0) container = $(this).parent();
    $('body').waitloader('show');
    $.postdata(this, url, data, function (data) {
      container.html(data);
      $('body').waitloader('remove');
    });
  });

  $('form input[data-role=submit]').on('click',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
    }
  );

  $("form#edit_form").init_input();

})(jQuery);