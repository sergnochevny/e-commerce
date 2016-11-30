(function ($) {

  $(document).off('.search_action');

  $(document).on('change', '[data-products_chk]',
    function (event) {
      var owl = $('[data-carousel]').data('owl.carousel');
      var pid = $(this).attr('data-pid');
      if (this.checked) {
        $(this).parents('label').addClass('checked');
        var product_name = $(this).parents('label').find('.product-desc').text();
        var style = $(this).parents('label').find('figure').attr('style');

        var element = '';
        element += '  <div class="product-item" data-pid="' + pid + '">';
        element += '    <div class="product-inner">';
        element += '      <figure class="product-image-box" style="' + style + '">';
        element += '        <input type="hidden" name="related[]" value="' + pid + '"/>';
        element += '      </figure>';
        element += '      <span class="product-category">' + product_name + '</span>';
        element += '      <a data-related_delete  href="delete" class="remove-related-product">×</a>';
        element += '    </div>';
        element += '  </div>';

        if (!owl) {
          $('[data-carousel]').owlCarousel(
            {
              responsive: {0: {items: 1}, 520: {items: 2}, 820: {items: 3}, 990: {items: 4}},
              margin: 15,
              nav: true,
              navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
              autoplay: true,
              loop: false,
              rewind: true,
              autoplayHoverPause: true,
              dots: true
            }
          );
          var owl = $('[data-carousel]').data('owl.carousel');
        }

        var idx = owl.add(element);
        $(this).attr('data-carousel_idx', idx);
      } else {
        $(this).parents('label').removeClass('checked');
        var owl_items = owl.items();
        $.each(owl_items,
          function (idx, item) {
            if ($(item).find('[data-pid=' + pid + ']').length) {
              owl.remove(idx);
              return false;
            }
          }
        );
      }
      if (!$('[data-related] .product-item').length) owl.destroy();
      else  owl.refresh();
    }
  );

  $(document).on('click', '[data-products_delete]',
    function (event) {
      var owl = $('[data-carousel]').data('owl.carousel');
      var pid = $(this).parents('.product-item').attr('data-pid');
      $('.clearance_products input[data-pid=' + pid + ']').removeAttr('checked');
      $('.clearance_products input[data-pid=' + pid + ']').parents('label').removeClass('checked');
      var owl_items = owl.items();
      $.each(owl_items,
        function (idx, item) {
          if ($(item).find('[data-pid=' + pid + ']').length) {
            owl.remove(idx);
            return false;
          }
        }
      );
      if (!$('[data-related] .product-item').length) owl.destroy();
      else  owl.refresh();
    }
  );

  function _postdata(this_, url, data) {
    $.postdata(this_, url, data,
      function (data) {
        $('[data-edit_products]').html(data);
      }
    );
  }

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

  $.change_button_text();


})(jQuery);
