(function ($) {
  'use srtict';

  $('#modal').on('hidden.bs.modal', function () {
    $(this).find('#modal_content').html('');
  });

  $(document).on('click.confirm_action', ".popup a.close", function (event) {
    event.preventDefault();
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
  });

  $(document).on('click.confirm_action', "#confirm_no", function (event) {
    event.preventDefault();
    $(".popup a.close").trigger('click');
  });

  $(document).on('click', '[data-delete]', function (event) {
    event.preventDefault();
    if (!$(this).is('.disabled')) {
      var href = $(this).attr('href');
      $("#confirm_action").on('click.confirm_action', function (event) {
        event.preventDefault();
        $('body').waitloader('show');
        $("#confirm_action").off('click.confirm_action');
        $("#confirm_dialog").removeClass('overlay_display');

        var data = new FormData();
        $.postdata(this, href, data,
          function (data) {
            $('#content').html(data);
            $('body').waitloader('remove');
          }
        );

      });
      $("#confirm_dialog").addClass('overlay_display');
    }
  });

  $(document).on('click', '#modal .save-data', function (event) {
    event.preventDefault();
    $('#edit_form').trigger('submit');
  });

  $(document).on('submit', '#edit_form', function (event) {
    event.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('action');
    var data = new FormData(this);
    $.postdata(this, url, data, function (data) {
      $('#content').html(data);
      $('#modal').modal('hide');
      $('body').waitloader('remove');
    });
  });

  $(document).on('click', '[data-modify]', function (event) {
    event.preventDefault();
    if (!$(this).is('.disabled')) {
      var url = $(this).attr('href');
      $('body').waitloader('show');
      $('#modal_content').load(url, function () {
        $('body').waitloader('remove');
      });
    }
  });

  $(document).on('click', '[data-view]', function (event) {
    event.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    $('#modal_content').load(url, function () {
      $('body').waitloader('remove');
    });
  });

})(window.jQuery || window.$);
