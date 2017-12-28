(function ($) {
  'use strict';

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

  $(document).on('submit', "form#edit_form", function (event) {
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

  $(document).on('click', 'form input[data-role=submit]',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
    }
  );

})(window.jQuery || window.$);
