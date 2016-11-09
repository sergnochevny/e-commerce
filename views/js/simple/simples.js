'use strict';
(function ($) {
  $(document).on('click.confirm_action', ".popup a.close", function (event) {
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
  });

  $(document).on('click.confirm_action', "#confirm_no", function (event) {
    $(".popup a.close").trigger('click');
  });

  $(document).on('click', 'a[data-delete]', function (event) {
    event.preventDefault();
    if (!$(this).is('.disabled')) {
      var href = $(this).attr('href');
      $("#confirm_action").on('click.confirm_action', function (event) {
        $('body').waitloader('show');
        event.preventDefault();
        $("#confirm_dialog").removeClass('overlay_display');

        var search = $('form[data-search]');
        if(search.length) var data = new FormData(search);
        else var data = new FormData(search);
        var sort = $('form[data-sort]');
        if (sort.length) {
          (new FormData(sort[0])).forEach(function (value, key) {
            data.append(key, value);
          });
        }
        $.postdata(this, href, data, function(data){$('#content').html(data);} );

        $("#confirm_action").off('click.confirm_action');
        $('body').waitloader('remove');
      });
      $("#confirm_dialog").addClass('overlay_display');
    }
  });
})(jQuery);