(function ($) {
  'use strict';

  var base_url = $('#base_url').val();

  $(document).off('.basket')
    .on('click', '.shop__sidebar-list a',
      function (event) {
        if ($(this).is('[disabled]')) {
          event.preventDefault();
          event.stopPropagation();
          return false;
        }
        return true;
      }
    ).on('click', '.shop__sidebar-list a[data-index]',
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
        data = new FormData($('form[data-filter-additional]')[0]);
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
      $.postdata(this, url, data,
        function (data) {
          var filter = JSON.parse(data);
          if (!el.is('[data-filter-item-active]')) {
            el.attr('data-filter-item-active', true);
            el.parents('.list-item').attr('data-filter-item-active', true);
          } else {
            el.removeAttr('data-filter-item-active');
            el.parents('.list-item').removeAttr('data-filter-item-active');
          }
          $('.shop__sidebar-buttons a').attr('disabled', true);
          $('[data-link-clear-filter]').attr('disabled', true);
          if (filter.hasOwnProperty('active_filter')) {
            $('.shop__sidebar-buttons a').removeAttr('disabled');
            Object.keys(filter).forEach(function (key) {
              $('.shop__sidebar-item[data-filter-prm="' + key + '"]').find('[data-link-clear-filter]').removeAttr('disabled');
            });
          }
          $('[data-filter-storage]').attr('data-filter-storage', data);
        }
      );
    }
  ).on('click', 'a[data-filter-apply]',
    function (event) {
      return !event.defaultPrevented;
      // if (!event.defaultPrevented) {
      //     event.preventDefault();
      //     var filter = JSON.parse($('[data-filter-storage]').attr('data-filter-storage')) || {},
      //       url = this.href,
      //       data;
      //     if ($('form[data-filter-additional]').length > 0) {
      //       data = new FormData($('form[data-filter-additional]')[0]);
      //       var limit = $('[data-limit]');
      //       if (limit.length) data.append('per_page', limit.val());
      //       var sort = $('form[data-sort]');
      //       if (sort.length) {
      //         var form = new FormData(sort[0]);
      //         for (var key in form.keys()) {
      //           if (form.hasOwnProperty(key)) data.append(key, form.get(key));
      //         }
      //       }
      //     } else {
      //       data = new FormData();
      //     }
      //     Object.keys(filter).forEach(function (key) {
      //       if (Array.isArray(filter[key])) {
      //         filter[key].forEach(function (item) {
      //           data.append('search[' + key + '][]', item);
      //         });
      //       } else {
      //         data.append('search[' + key + ']', filter[key]);
      //       }
      //     });
      //     $.postdata(this, url, data,
      //       function (data) {
      //         if (window.location.href !== url) window.history.pushState(null, null, url);
      //         $('#content').html(data);
      //         $('body').waitloader('remove');
      //       }
      //     );
      //     return false;
      // }
      // return true;
    }
  ).on('click', 'a[data-filter-reset]',
    function (event) {
      if (!event.defaultPrevented) {
        event.preventDefault();
        var url = this.href,
          data = new FormData();
        data.append('search[reset_filter]', true);
        $.postdata(this, url, data,
          function (data) {
            $('[data-filter-storage]').attr('data-filter-storage', data);
            data = JSON.parse(data);
            if (!data.hasOwnProperty('active_filter')) {
              $('.shop__sidebar-buttons a').attr('disabled', true);
              $('a[data-link-clear-filter]').attr('disabled', true);
            }
            $('form[data-search]').trigger('submit');
          }
        );
        return false;
      }
      return true;
    }
  ).on('click', 'a[data-link-clear-filter]',
    function (event) {
      if (!event.defaultPrevented) {
        event.preventDefault();
        var filter = JSON.parse($('[data-filter-storage]').attr('data-filter-storage')) || {},
          url = this.href,
          this_ = this,
          data_filter_prm = $(this).parents('li[data-filter-prm]').attr('data-filter-prm'),
          data;
        if ($('form[data-filter-additional]').length > 0) {
          data = new FormData($('form[data-filter-additional]')[0]);
          var limit = $('[data-limit]');
          if (limit.length) data.append('per_page', limit.val());
          var sort = $('form[data-sort]');
          if (sort.length) {
            var form = new FormData(sort[0]);
            for (var key in form.keys()) {
              if (form.hasOwnProperty(key)) data.append(key, form.get(key));
            }
          }
        } else {
          data = new FormData();
        }
        Object.keys(filter).forEach(function (key) {
          if (key !== data_filter_prm) {
            if (Array.isArray(filter[key])) {
              filter[key].forEach(function (item) {
                data.append('search[' + key + '][]', item);
              });
            } else {
              data.append('search[' + key + ']', filter[key]);
            }
          }
        });
        $.postdata(this, url, data,
          function (_data) {
            $('[data-filter-storage]').attr('data-filter-storage', _data);
            _data = JSON.parse(_data);
            $(this_).attr('disabled', true);
            if (!_data.hasOwnProperty('active_filter')) {
              $('.shop__sidebar-buttons a').attr('disabled', true);
            }
            $('form[data-search]').trigger('submit');
          }
        );
        return false;
      }
      return true;
    }
  );

})(window.jQuery || window.$);