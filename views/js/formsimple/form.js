'use strict';
(function ($) {
  $("input").inputmask();

  $.danger_remove(8000);

  $("form#edit_form").on('submit', function (event) {
    event.preventDefault();
    var url = $(this).attr('action');
    var data = new FormData(this);
    var container = $(this).parents('[data-role=form_content]');
    if (container.length == 0) container = $(this).parent();
    $('body').waitloader('show');
    $.postdata(this, url, data, function (data) {
      container.html(data);
    });
  });

  $('form input[data-role=submit]').on('click',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
    }
  );

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();
  $('input[type=email]').textinput();
  $('input[type=password]').textinput();

  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);