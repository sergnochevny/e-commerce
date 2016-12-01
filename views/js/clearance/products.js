(function ($) {

  $(document).off('.search_action');

  $(document).on('change', '[data-clearance_chk]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var url = $(this).attr('data-action');
      var data = new FormData();
      if (this.checked) {
        data.append('pid', $(this).attr('data-pid'));
        var callback = function (data) {
          $('[data-role=form_content]').html(data);
        };
      } else {
        var callback = function (data) {
          $('[data-edit_products]').html(data);
        };
      }
      $.postdata(this, url, data, callback);
    }
  );

  $(document).on('submit.search_action', '[data-products_block] form[data-search]',
    function (event, reset) {
      event.stopPropagation();
      event.preventDefault();
      if (reset) {
        var data = new FormData();
      } else {
        var data = new FormData(this),
          search = $('[data-products_block] form[data-sort]');
        if (search.length) {
          (new FormData(search[0])).forEach(function (value, key) {
            data.append(key, value);
          });
        }
      }
      _postdata(this, $(this).attr('action'), data);
    }
  );

  $(document).on('click.search_action', '[data-products_block] form[data-search] [data-search_reset]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      $('[data-products_block] form[data-search]').trigger('submit', [true]);
    }
  );

  $(document).on('click.search_action', '[data-products_block] form[data-search] [data-search_submit]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      $('[data-products_block] form[data-search]').trigger('submit');
    }
  );

  $(document).on('click.search_action', '[data-products_block] [data-to_page]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var search = $('[data-products_block] form[data-search]');
      if (search.length) {
        search.attr('action', $(this).attr('href')).trigger('submit');
      } else {
        var data = new FormData();
        if (search.length) {
          data = new FormData(search[0]);
        }
        _postdata(this, $(this).attr('href'), data);
      }
    }
  );

  $(document).on('click.search_action', '[data-products_block] [data-sort]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var search = $('[data-products_block] form[data-search]');
      if (search.length) {
        search.attr('action', $(this).attr('href')).trigger('submit');
      } else {
        var data = new FormData();
        _postdata(this, $(this).attr('href'), data);
      }
    }
  );

  function LoadContent() {
    debugger;
    $('body').waitloader('show');
    var products = $('[data-edit_products]');
    var url = $('[data-products_get_list]').val();
    products.load(url, function () {
      $.init_input();
      $('body').waitloader('remove');
      $.danger_remove(5000);
    });
  }

  $(document).on('load','[data-role=form_content]',
    function(){
      LoadContent();
    }
  );

  $.change_button_text();

})(jQuery);
