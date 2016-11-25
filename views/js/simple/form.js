(function ($) {

  $(":input").inputmask();

  $('#modal .save-data').on('click', function (event) {
    $('#modal .save-data').off();
    $('#edit_form').trigger('submit');
  });

  $('#modal-title').html($('#edit_form').attr('data-title'));
  $('#modal').modal('show');


  $('#edit_form').on('submit', function (event) {
    event.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('action');
    var data = new FormData(this);
    $.postdata(this, url, data, function (data) {
      $('#content').html(data);
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
