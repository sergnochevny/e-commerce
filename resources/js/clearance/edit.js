(function ($) {

  function _postdata(this_, url, data, callback) {
    $.postdata(this_, url, data,
      function (data) {
        $.when($('[data-products_block]').html(data)).done(
          function () {
            if (callback) callback.call(this_);
          }
        );
      }
    );
  }

  function LoadFormContent() {
    $('body').waitloader('show');
    var url = $('[data-products_get_list]').val();
    var search = $('[data-products_block] form[data-search]');
    var data = new FormData();
    if (search.length) {
      var form = new FormData(search[0]);
      for (var key in form.keys()) {
        if(form.hasOwnProperty(key)) data.append(key, form.get(key));
      }
    }
    _postdata(this, url, data,
      function () {
        $('body').init_input();
        $('body').waitloader('remove');
        $.danger_remove(3000);
      }
    );
  }

  $(document).off('.search_action').on('change', '[data-clearance_chk]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      $('body').waitloader('show');
      var url = $(this).attr('data-action');
      var data = new FormData();
      var search = $('[data-products_block] form[data-search]');
      if (search.length) {
        var form = new FormData(search[0]);
        for (var key in form.keys()) {
          if(form.hasOwnProperty(key)) data.append(key, form.get(key));
        }
      }
      if (this.checked) {
        data.append('pid', $(this).attr('data-pid'));
        var callback = function (data) {
          $.when($('[data-role=form_content]').html(data)).done(function () {
            LoadFormContent();
            $('body').waitloader('remove');
          });
        };
      } else {
        var callback = function (data) {
          $('[data-products_block]').html(data);
          $('body').waitloader('remove');
        };
      }
      $.postdata(this, url, data, callback, false, false);
    }
  ).on('submit.search_action', '[data-products_block] form[data-search]',
    function (event, reset) {
      event.stopPropagation();
      event.preventDefault();
      if (reset) {
        var data = new FormData();
        data.append('search[reset]', true);
      } else {
        var data = new FormData(this);
      }
      var sort = $('[data-products_block] form[data-sort]');
      if (sort.length) {
        var form = new FormData(sort[0]);
        for (var key in form.keys()) {
          if(form.hasOwnProperty(key)) data.append(key, form.get(key));
        }
      }
      _postdata(this, $(this).attr('action'), data);
    }
  ).on('click.search_action', '[data-products_block] form[data-search] [data-search_reset]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      $('[data-products_block] form[data-search]').trigger('submit', [true]);
    }
  ).on('click.search_action', '[data-products_block] form[data-search] [data-search_submit]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      $('[data-products_block] form[data-search]').trigger('submit');
    }
  ).on('click.search_action', '[data-products_block] [data-to_page]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var search = $('[data-products_block] form[data-search]');
      if (search.length) {
        search.attr('action', $(this).attr('href')).trigger('submit');
      } else {
        var data = new FormData();
        var sort = $('[data-products_block] form[data-sort]');
        if (sort.length) {
          var form = new FormData(sort[0]);
          for (var key in form.keys()) {
            if(form.hasOwnProperty(key)) data.append(key, form.get(key));
          }
        }
        _postdata(this, $(this).attr('href'), data);
      }
    }
  ).on('click.search_action', '[data-products_block] [data-sort]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var search = $('[data-products_block] form[data-search]');
      if (search.length) {
        search.attr('action', $(this).attr('href')).trigger('submit');
      } else {
        var data = new FormData();
        var sort = $('[data-products_block] form[data-sort]');
        if (sort.length) {
          var form = new FormData(sort[0]);
          for (var key in form.keys()) {
            if(form.hasOwnProperty(key)) data.append(key, form.get(key));
          }
        }
        _postdata(this, $(this).attr('href'), data);
      }
    }
  );

  LoadFormContent();

  $.change_button_text();

})(window.jQuery || window.$);
