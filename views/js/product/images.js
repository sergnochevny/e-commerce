'use strict';
(function ($) {

  function postdata(this_, url, data, context, callback) {
    $('body').waitloader('show');
    $.ajax({
      type: 'POST',
      url: url,
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: function (data) {
        if (context !== undefined && context !== null) {
          $.when(context.html(data)).done(
            function () {
              if (callback) callback.call(this_, data);
              $('body').waitloader('remove');
            }
          );
        } else {
          if (callback) callback.call(this_, data);
          $('body').waitloader('remove');
        }
      },
      error: function (xhr, str) {
        alert('Error: ' + xhr.responseCode);
        $('body').waitloader('remove');
      },
    });
  }

  $(document).on('click', '.b_modify_images_pic_main_icon',
    function (event) {
      event.preventDefault();
      var data = new FormData($('form#edit_form')[0]);
      var url = $('form#edit_form').attr('action');
      data.append('method', 'images.main');
      data.append('idx', $(this).attr('data-img_idx'));
      postdata(this, url, data, $('#images'));
    }
  );

  $(document).on('click.confirm_action', ".popup a.close",
    function (event) {
      $("#confirm_action").off('click.confirm_action');
      $("#confirm_dialog").removeClass('overlay_display');
    }
  );

  $(document).on('click.confirm_action', "#confirm_no",
    function (event) {
      $(".popup a.close").trigger('click');
    }
  );

  $(document).on('click', 'a.pic_del_images',
    function (event) {
      event.preventDefault();
      if (!$(this).is('.disabled')) {
        var idx = $(this).attr('data-img_idx');
        $("#confirm_action").on('click.confirm_action',
          function (event) {
            $('body').waitloader('show');
            event.preventDefault();
            $("#confirm_dialog").removeClass('overlay_display');
            var data = new FormData($('form#edit_form')[0]);
            var url = $('form#edit_form').attr('action');
            data.append('method', 'images.delete');
            data.append('idx', idx);
            postdata(this, url, data, $('#images'));
            $("#confirm_action").off('click.confirm_action');
            $('body').waitloader('remove');
          }
        );
        $("#confirm_dialog").addClass('overlay_display');
      }
    }
  );

})(jQuery);
