(function ($) {
    'use strict';

    var status = $('#status');

    function fileFromPath(file) {
      return file.replace(/.*(\/|\\)/, "");
    }

    function getExt(file) {
      return (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : '';
    }

    $(window).on('resize', function () {
      var main_img = $('[data-img_main]'),
        secondary_img = $('[data-img]');

      main_img.height((main_img.width() - 160) + 'px');
      secondary_img.height((secondary_img.width() - 180) + 'px');

    }).trigger('resize');

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
            $.when($(context[0]).html(data)).done(
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
        }
      });
    }

    $(document).on('click', '[data-img_set_main]',
      function (event) {
        event.preventDefault();
        var data = new FormData($('form#edit_form')[0]);
        var url = $('form#edit_form').attr('action');
        data.append('method', 'images.main');
        data.append('idx', $(this).attr('data-img_idx'));
        postdata(this, url, data, $('#images'),
          function () {
            $(window).trigger('resize');
          }
        );
      }
    ).on('click.confirm_action', ".popup a.close",
      function (event) {
        event.preventDefault();
        $("#confirm_action").off('click.confirm_action');
        $("#confirm_dialog").removeClass('overlay_display');
      }
    ).on('click.confirm_action', "#confirm_no",
      function (event) {
        event.preventDefault();
        $(".popup a.close").trigger('click');
      }
    ).on('click', 'a[data-img_del]',
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
              postdata(this, url, data, $('#images'),
                function () {
                  $(window).trigger('resize');
                }
              );
              $("#confirm_action").off('click.confirm_action');
              $('body').waitloader('remove');
            }
          );
          $("#confirm_dialog").addClass('overlay_display');
        }
      }
    ).on('click', '[data-img_upload]',
      function (event) {
        event.preventDefault();
        $('[data-img_uploadfile]').trigger('click');
      }
    ).on('change', '[data-img_uploadfile]',
      function (event) {
        event.preventDefault();

        var file = fileFromPath(this.value);
        var ext = getExt(file);

        if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
          status.text('Error format');
        } else {
          var data = new FormData($('form#edit_form')[0]);
          var url = $('form#edit_form').attr('action');
          data.append('method', 'images.upload');
          data.append('idx', (!$('input[name=images]:checked').val()) ? 1 : $('input[name=images]:checked').val());
          postdata(this, url, data, $('#images'),
            function () {
              $(window).trigger('resize');
            }
          );
        }
      }
    );

  }

)(window.jQuery || window.$);
