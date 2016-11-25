'use strict';

(function ($) {

  $.danger_remove(8000);

  $('#modal').on('hidden.bs.modal', function () {
    $(this).find('#modal_content').empty();
  });

  $('[data-modify]').on('click', function (event) {
    event.preventDefault();
    if (!$(this).is('.disabled')) {
      var url = $(this).attr('href');
      $('body').waitloader('show');
      $('#modal_content').load(url, function () {
        $('body').waitloader('remove');
      });
    }
  });

  $('[data-view]').on('click', function (event) {
    event.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    $('#modal_content').load(url, function () {
      $('body').waitloader('remove');
    });
  });

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();
  $('input[type=email]').textinput();
  $('input[type=password]').textinput();

  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);