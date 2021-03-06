(function ($) {
  'use strict';

  function postdata(this_, url, data) {
    $.postdata(this_, url, data,
      function (data) {
        $('#content').html(data);
      }
    );
  }

  $(document).on('submit.search_action', 'form[data-search]', function (event, reset) {
    event.preventDefault();
    event.stopPropagation();
    var data = {},
      f_search = $('#f_search');
    if (reset) {
      data = new FormData();
      data.append('search[reset]', true);
      f_search.addClass('hidden');
      f_search[0] && f_search[0].reset();
    } else {
      if ($('[name="search[a.pname]"]').length) {
        $('#search').attr('value', $('[name="search[a.pname]"]').attr('value'));
      }
      data = new FormData(this);
      if ($(this).is('[data-filter-additional]') && ($('[data-filter-storage]').length > 0)) {
        var filter = JSON.parse($('[data-filter-storage]').attr('data-filter-storage')) || {};
        Object.keys(filter).forEach(function (key) {
          if (Array.isArray(filter[key])) {
            filter[key].forEach(function (item) {
              data.append('search[' + key + '][]', item);
            });
          } else {
            data.append('search[' + key + ']', filter[key]);
          }
        });
      }
    }
    var sort = $('form[data-sort]');
    if (sort.length) {
      var form = new FormData(sort[0]);
      for (var key in form.keys()) {
        if (form.hasOwnProperty(key)) data.append(key, form.get(key));
      }
    }
    var limit = $('[data-limit]');
    if (limit.length) data.append('per_page', limit.val());
    postdata(this, $(this).attr('action'), data);
  }).on('click.search_action', '[data-search_reset]', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $('form[data-search]').trigger('submit', [true]);
  }).on('click.search_action', '[data-search_submit]', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $('form[data-search]').trigger('submit');
  }).on('click.search_action', '[data-to_page]', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var search = $('form[data-search]');
    if (search.length) {
      search.attr('action', $(this).attr('href'));
      search.trigger('submit');
    } else {
      var data = new FormData();
      data.append('search[null]', 'null');
      var sort = $('form[data-sort]');
      if (sort.length) {
        var form = new FormData(sort[0]);
        for (var key in form.keys()) {
          if (form.hasOwnProperty(key)) data.append(key, form.get(key));
        }
      }
      var limit = $('[data-limit]');
      if (limit.length) data.append('per_page', limit.val());

      postdata(this, $(this).attr('href'), data);
    }
  }).on('click.search_action', '[data-sort]', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var search = $('form[data-search]');
    if (search.length) {
      search.attr('action', $(this).attr('href'));
      search.trigger('submit');
    } else {
      var data = new FormData();
      data.append('search[null]', 'null');
      var sort = $('form[data-sort]');
      if (sort.length) {
        var form = new FormData(sort[0]);
        for (var key in form.keys()) {
          if (form.hasOwnProperty(key)) data.append(key, form.get(key));
        }
      }
      var limit = $('[data-limit]');
      if (limit.length) data.append('per_page', limit.val());

      postdata(this, $(this).attr('href'), data);
    }
  }).on('change.search_action', '[data-limit]', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var search = $('form[data-search]');
    if (search.length) {
      search.attr('action', window.location.href);
      search.trigger('submit');
    } else {
      var data = new FormData();
      data.append('search[null]', 'null');
      var sort = $('form[data-sort]');
      if (sort.length) {
        var form = new FormData(sort[0]);
        for (var key in form.keys()) {
          if (form.hasOwnProperty(key)) data.append(key, form.get(key));
        }
      }
      var limit = $('[data-limit]');
      if (limit.length) data.append('per_page', limit.val());

      postdata(this, window.location.href, data);
    }
  }).on('selectmenuchange.search_action', '[data-limit]',
    function (event) {
      $(this).trigger('change');
    }
  );

})(window.jQuery || window.$);