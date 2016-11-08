(function ($) {

  $('[data-related_add_ok]').on('click',
    function (event) {
      event.preventDefault();
      $('[data-edit_related]').empty();
      $('[data-related-add]').show();
      $('[data-fields_block]').show();
      $('[data-submit_btn]').show();
    }
  );

  $('[data-related_chk]').on('change',
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
        element += '    </div>';
        element += '  </div>';

        if (!owl) {
          $('[data-carousel]').owlCarousel(
            {
              responsive: {0: {items: 1}, 461: {items: 2}, 721: {items: 2}, 992: {items: 3}},
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

  function _postdata(this_, url, data) {
    $.postdata(this_, url, data,
      function () {
        var owl = $('[data-carousel]').data('owl.carousel');
        if (owl) {
          var owl_items = owl.items();
          $.each(owl_items, function (idx, item) {
              if ($(item).find('[data-pid]').length) {
                var pid = $(item).find('[data-pid]').attr('data-pid');
                $('.related_products input[data-pid=' + pid + ']').attr('checked', true);
                $('.related_products input[data-pid=' + pid + ']').parents('label').addClass('checked');
              }
            }
          );
        }
      }
    );
  }

  $('[data-related_block] form[data-search]').on('submit.search_action', function (event, reset) {
    event.preventDefault();
    if (reset) {
      var data = new FormData();
    } else {
      var data = new FormData(this),
        search = $('[data-related_block] form[data-sort]');
      if (search.length) {
        (new FormData(search[0])).forEach(function (value, key) {
          data.append(key, value);
        });
      }
    }
    _postdata(this, $(this).attr('action'), data);
  });

  $('[data-related_block] form[data-search] [data-search_reset]').on('click.search_action', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $('[data-related_block] form[data-search]').trigger('submit', true);
  });

  $('[data-related_block] form[data-search] [data-search_submit]').on('click.search_action', function () {
    $('[data-related_block] form[data-search]').trigger('submit');
  });

  $('[data-related_block] [data-to_page]').on('click.search_action', function (event) {
    event.preventDefault();
    var search = $('[data-related_block] form[data-search]');
    if (search.length) {
      search.attr('action', $(this).attr('href')).trigger('submit');
    } else {
      var data = new FormData();
      if (search.length) {
        data = new FormData(search[0]);
      }
      _postdata(this, $(this).attr('href'), data);
    }
  });

  $('[data-related_block] [data-sort]').on('click.search_action', function (event) {
    event.preventDefault();
    var search = $('[data-related_block] form[data-search]');
    if (search.length) {
      search.attr('action', $(this).attr('href')).trigger('submit');
    } else {
      var data = new FormData();
      _postdata(this, $(this).attr('href'), data);
    }
  });

})(jQuery);
