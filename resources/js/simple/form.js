'use strict';

(function ($) {

  $("input").inputmask();

  $('#modal .save-data').on('click', function (event) {
    $('#modal .save-data').off();
    $('#edit_form').trigger('submit');
  });

  $('#modal-title').html($('#edit_form').attr('data-title'));
  $('#modal').modal('show');


  $('#edit_form').on('submit', function (event) {
    event.preventDefault();
    $('#content').waitloader('show');
    var url = $(this).attr('action');
    var data = new FormData(this);
    $.postdata(this, url, data, function (data) {
      $('#content').html(data);
    });
  });

  $('form#edit_form').init_input();

})(jQuery);
