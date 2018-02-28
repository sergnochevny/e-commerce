(function ($) {
  'use strict';

  var base_url = $('#base_url').val();

  $(document).off('.basket').on('click', '.shop__sidebar-list a[data-index]',
    function (event) {
      $('.shop__sidebar-list .active').removeClass('active');
      $(this).addClass('active');
    }
  ).on('click', '[data-product]',
    function (event) {
      event.preventDefault();
      if ($(this).find(' > a').length) {
        $('body').waitloader('show');
        location.href = $(this).find(' > a').attr('href');
      }
    }
  ).on('click', '[data-product] > a', function (event) {
    event.stopPropagation();
  }).on('click', '[data-filter]',
    function (event) {
      event.preventDefault();
      var filter = JSON.parse($('[data-filter-storage]').attr('data-filter-storage')) || {},
        data_filter_prm = $(this).attr('data-filter-prm'),
        data_filter_val = $(this).attr('data-filter-val'),
        url = this.href,
        data,
        el = $(this);
      if ($('form[data-filter-additional]').length > 0) {
        data = new FormData($('form[data-filter-additional]'));
      } else {
        data = new FormData();
      }
      if (!el.is('[data-filter-item-active]')) {
        if (filter.hasOwnProperty(data_filter_prm) && Array.isArray(filter[data_filter_prm])) {
          filter[data_filter_prm].push(data_filter_val);
        } else {
          filter[data_filter_prm] = [data_filter_val];
        }
      } else {
        if (filter.hasOwnProperty(data_filter_prm) && Array.isArray(filter[data_filter_prm])) {
          var idx = filter[data_filter_prm].indexOf(data_filter_val);
          if (idx > -1) {
            var arr_data_filter_prm = filter[data_filter_prm];
            arr_data_filter_prm.splice(idx, 1);
            filter[data_filter_prm] = arr_data_filter_prm;
          }
        }
      }
      Object.keys(filter).forEach(function (key) {
        if (Array.isArray(filter[key])) {
          filter[key].forEach(function (item) {
            data.append('search[' + key + '][]', item);
          });
        } else {
          data.append('search[' + key + ']', filter[key]);
        }
      });
      $('body').waitloader('show');
      $.postdata(this, url, data,
        function (data) {
          if (!el.is('[data-filter-item-active]')) {
            el.attr('data-filter-item-active', true);
            el.parents('.list-item').attr('data-filter-item-active', true);
          } else {
            el.removeAttr('data-filter-item-active');
            el.parents('.list-item').removeAttr('data-filter-item-active');
          }
          $('[data-filter-storage]').attr('data-filter-storage', data);
          $('body').waitloader('remove');
        },
        function (xhr, str) {
          $('body').waitloader('remove');
        }, false
      );
    }
  );

})(window.jQuery || window.$);