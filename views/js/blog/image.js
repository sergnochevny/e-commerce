'use strict';
(function ($) {

  var status = $('#status');

  function fileFromPath(file) {
    return file.replace(/.*(\/|\\)/, "");
  }

  function getExt(file) {
    return (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : '';
  }

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

  $(document).on('click', '#post_img',
    function (event) {
      event.preventDefault();
      $('#uploadfile').trigger('click');
    }
  );

  $(document).on('change', '#uploadfile',
    function (event) {
      event.preventDefault();

      var file = fileFromPath(this.value);
      var ext = getExt(file);

      if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
        status.text('Error format');
      } else {
        var data = new FormData($('form#edit_form')[0]);
        var url = $('form#edit_form').attr('action');
        data.append('method', 'image.upload');
        postdata(this, url, data, $('#image'));
      }
    }
  );

})(jQuery);
