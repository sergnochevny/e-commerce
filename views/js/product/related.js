(function ($) {

  $(document).off('.search_action');
  $(document).on('click', '[data-related_add_ok]',
    function (event) {
      event.preventDefault();
      $('[data-edit_related]').empty();
      $('[data-related_block]').hide();
      $('[data-related-add]').show();
      $('[data-fields_block]').show();
      $('[data-submit_btn]').show();
    }
  );

  $(document).on('change', '[data-related_chk]',
    function (event) {
      var owl = $('[data-carousel]').data('owl.carousel');
      var pid = $(this).attr('data-pid');
      if (this.checked) {
        $(this).parents('label').addClass('checked');
        var product_name = $(this).parents('label').find('.product-desc').text();
        var style = $(this).parents('label').find('figure').attr('style');

        var element = '';
        element += '  <div class="product-item product-related" data-pid="' + pid + '">';
        element += '    <div class="product-inner">';
        element += '      <figure class="product-image-box" style="' + style + '">';
        element += '        <input type="hidden" name="related[]" value="' + pid + '"/>';
        element += '      </figure>';
        element += '      <div class="product-description">';
        element += '        <div class="product-name">' + product_name + '</div>';
        element += '      </div>';
        element += '      <a data-related_delete  href="jscript:void(0);" class="remove-related-product">×</a>';
        element += '    </div>';
        element += '  </div>';

        if (!owl) {
          $('[data-carousel]').owlCarousel(
            {
              responsive: {0: {items: 1}, 520: {items: 2}, 820: {items: 3}, 990:{items: 4}},
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

  $(document).on('click', '[data-related_delete]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var owl = $('[data-carousel]').data('owl.carousel');
      var pid = $(this).parents('.product-item').attr('data-pid');
      $('.related_products input[data-pid=' + pid + ']').removeAttr('checked');
      $('.related_products input[data-pid=' + pid + ']').parents('label').removeClass('checked');
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
        $.when(
          $('[data-edit_related]').html(data)
        ).done(function () {
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
        });
      }
    );
  }

  $(document).on('submit.search_action', '[data-related_block] form[data-search]',
    function (event, reset) {
      event.stopPropagation();
      event.preventDefault();
      if (reset) {
        var data = new FormData();
      } else {
        var data = new FormData(this);
      }
      var sort = $('[data-related_block] form[data-sort]');
      if (sort.length) {
        (new FormData(sort[0])).forEach(function (value, key) {
          data.append(key, value);
        });
      }
      _postdata(this, $(this).attr('action'), data);
    }
  );

  $(document).on('click.search_action', '[data-related_block] form[data-search] [data-search_reset]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      $('[data-related_block] form[data-search]').trigger('submit', [true]);
    }
  );

  $(document).on('click.search_action', '[data-related_block] form[data-search] [data-search_submit]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      $('[data-related_block] form[data-search]').trigger('submit');
    }
  );

  $(document).on('click.search_action', '[data-related_block] [data-to_page]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var search = $('[data-related_block] form[data-search]');
      if (search.length) {
        search.attr('action', $(this).attr('href')).trigger('submit');
      } else {
        var data = new FormData();
        var sort = $('[data-related_block] form[data-sort]');
        if (sort.length) {
          (new FormData(sort[0])).forEach(function (value, key) {
            data.append(key, value);
          });
        }
        _postdata(this, $(this).attr('href'), data);
      }
    }
  );

  $(document).on('click.search_action', '[data-related_block] [data-sort]',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var search = $('[data-related_block] form[data-search]');
      if (search.length) {
        search.attr('action', $(this).attr('href')).trigger('submit');
      } else {
        var data = new FormData();
        var sort = $('[data-related_block] form[data-sort]');
        if (sort.length) {
          (new FormData(sort[0])).forEach(function (value, key) {
            data.append(key, value);
          });
        }
        _postdata(this, $(this).attr('href'), data);
      }
    }
  );

  $(document).on('click', '[data-related-add]',
    function (event) {
      event.preventDefault();
      var this_ = this;
      var related = $('[data-edit_related]');
      var url = $('[data-related_get_list]').val();
      $(this_).hide();
      $(related).waitloader('show');
      related.load(url, function () {
        $('[data-fields_block]').hide();
        $('[data-submit_btn]').hide();
        $('[data-related_block]').show();
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
        $('body').stop().animate({scrollTop: 0});
      });
    }
  );

  $.change_button_text();

})(jQuery);
