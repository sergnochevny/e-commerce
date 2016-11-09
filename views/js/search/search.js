'use strict';
(function ($) {

  function postdata(url, data) {
    $.postdata(this, url, data,
      function(data){
        $('#content').html(data);
      }
    );
  }

  $(document).on('submit.search_action', "form[data-search]", function (event, reset) {
    event.preventDefault();
    event.stopPropagation();
    if (reset) {
      var data = new FormData();
    } else {
      var data = new FormData(this),
        sort = $('form[data-sort]');
      if (sort.length) {
        (new FormData(sort[0])).forEach(function (value, key) {
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

  $(document).on('click.search_action', "form[data-search] [data-search_submit]", function (event) {
    event.preventDefault();
    event.stopPropagation();
    $('form[data-search]').trigger('submit');
  });

  $(document).on('click.search_action', "[data-to_page]", function (event) {
    event.preventDefault();
    event.stopPropagation();
    var search = $('form[data-search]');
    if (search.length) {
      search.attr('action', $(this).attr('href')).trigger('submit');
    } else {
      var data =  new FormData();
      if (search.length) {
        data = new FormData(search[0]);
      }
      postdata($(this).attr('href'), data);
    }
  });

  $(document).on('click.search_action', "[data-sort]", function (event) {
    event.preventDefault();
    event.stopPropagation();
    var search = $('form[data-search]');
    if (search.length) {
      search.attr('action', $(this).attr('href')).trigger('submit');
    } else {
      var data = new FormData();
      postdata($(this).attr('href'), data);
    }
  });

})(jQuery);