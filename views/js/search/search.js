'use strict';
(function ($) {

  function postdata(url, data) {
    $('body').waitloader('show');
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

  $(document).on('submit.search_action', "form[data-search]", function (event, reset) {
    event.preventDefault();
    if (reset) {
      data = {};
    } else {
      var data = new FormData(this);
      if ($('form[data-sort]').length) {
        (new FormData($('form[data-sort]')[0])).forEach(function (value, key) {
          data.append(key, value);
        });
      }
    }
    postdata.call(this, $(this).attr('action'), data);
  });

  $(document).on('click.search_action', "form[data-search] [data-search_reset]", function (event) {
    event.preventDefault();
    event.stopPropagation();
    $('form[data-search]').trigger('submit', true);
  });

  $(document).on('click.search_action', "form[data-search] [data-search_submit]", function () {
    $('form[data-search]').trigger('submit');
  });

  $(document).on('click.search_action', "[data-to_page]", function (event) {
    event.preventDefault();
    if ($('form[data-search]').length) {
      $('form[data-search]').attr('action', $(this).attr('href'));
      $('form[data-search]').trigger('submit');
    } else {
      var data = {};
      if ($('form[data-sort]').length) {
        data = new FormData($('form[data-sort]')[0]);
      }
      postdata($(this).attr('href'), data);
    }
  });

  $(document).on('click.search_action', "[data-sort]", function (event) {
    event.preventDefault();
    if ($('form[data-search]').length) {
      $('form[data-search]').attr('action', $(this).attr('href'));
      $('form[data-search]').trigger('submit');
    } else {
      postdata($(this).attr('href'), {});
    }
  });

})(jQuery);