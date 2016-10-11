'use strict';
(function ($) {
  $(document).on('submit.search_action', "form[data-search]",
    function (event) {
      event.preventDefault();
      $('body').waitloader('show');
      var url = $(this).attr('action');
      debugger;
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

  $(document).on('click.search_action', "form[data-search] [data-search_reset]",
    function (event) {
      $('form[data-search]').trigger('submit');
    }
  );

  $(document).on('click.search_action', "form[data-search] [data-search_submit]",
    function (event) {
      $('form[data-search]').trigger('submit');
    }
  );
})(jQuery);