'use strict';
(function ($) {

  function postdata(url, senddata) {
    $('body').waitloader('show');
    var data = {};
    if (senddata != false) data = new FormData(this);
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

  $(document).on('submit.search_action', "form[data-search]",
    function (event, senddata) {
      event.preventDefault();
      postdata.call(this, $(this).attr('action'), senddata);
    }
  );

  $(document).on('click.search_action', "form[data-search] [data-search_reset]",
    function (event) {
      $('form[data-search]').trigger('submit', false);
    }
  );

  $(document).on('click.search_action', "form[data-search] [data-search_submit]",
    function (event) {
      $('form[data-search]').trigger('submit', true);
    }
  );

  $(document).on('click.search_action', "[data-to_page]",
    function (event) {
      event.preventDefault();
      if ($('form[data-search]').length) {
        $('form[data-search]').attr('action', $(this).attr('href'));
        $('form[data-search]').trigger('submit', true);
      } else {
        postdata($(this).attr('href'), false);
      }
    }
  );

})(jQuery);