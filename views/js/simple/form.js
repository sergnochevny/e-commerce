(function ($) {

    $('#modal .save-data').on('click',
      function (event) {
        $('#modal .save-data').off();
        $('#edit_form').trigger('submit');
      }
    );

    $('#modal-title').html($('#edit_form').attr('data-title'));
    $('#modal').modal('show');


    $('#edit_form').on('submit',
      function (event) {
        event.preventDefault();
        $('body').waitloader('show');
        var url = $(this).attr('action');
        var data = new FormData(this);
        $.ajax({
          type: 'POST',
          url: url,
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function (data) {
            $.when(
              $('#content').html(data)
            ).done(
              function () {
                $('body').waitloader('remove');
              }
            );
          },
          error: function (xhr, str) {
            alert('Error: ' + xhr.responseCode);
            $('body').waitloader('remove');
          }
        });
      }
    );
  })(jQuery);
