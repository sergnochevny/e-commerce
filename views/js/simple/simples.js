'use strict';
(function ($) {
  $(document).on('click.confirm_action', ".popup a.close", function (event) {
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
  });

  $(document).on('click.confirm_action', "#confirm_no", function (event) {
    $(".popup a.close").trigger('click');
  });

  $(document).on('click', '[data-delete]', function (event) {
    event.preventDefault();
    if (!$(this).is('.disabled')) {
      var href = $(this).attr('href');
      $("#confirm_action").on('click.confirm_action', function (event) {
        event.preventDefault();
        $('#content').waitloader('show');
        $("#confirm_action").off('click.confirm_action');
        $("#confirm_dialog").removeClass('overlay_display');

        var data = new FormData();
        $.postdata(this, href, data,
          function (data) {
            $('#content').html(data);
          }
        );

      });
      $("#confirm_dialog").addClass('overlay_display');
    }
  });
})(jQuery);