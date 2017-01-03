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
    $.postdata(this_, url,data,
      function (data) {
        if (context !== undefined && context !== null) {
          $.when($(context[0]).html(data)).done(
            function () {
              if (callback) callback.call(this_, data);
            }
          );
        } else {
          if (callback) callback.call(this_, data);
        }
      }
    );
  }

  $(document).on('click', '[data-post_img]',
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
