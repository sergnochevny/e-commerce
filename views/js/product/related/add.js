(function ($) {

  $('[data-related_add_ok]').on('click',
    function (event) {
      debugger;
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
        element += '  <div class="product-item" data-pid_' + pid + '>';
        element += '    <div class="product-inner">';
        element += '      <figure class="product-image-box" style="' + style + '">';
        element += '        <input type="hidden" name="related[]" value="' + pid + '"/>';
        element += '      </figure>';
        element += '      <span class="product-category">' + product_name + '</span>';
        element += '    </div>';
        element += '  </div>';

        if(!owl){
          $('[data-carousel]').owlCarousel(
            {
              responsive: {0: {items: 1}, 461: {items: 2}, 721: {items: 2}, 992: {items: 3}},
              nav: true,
              navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
              autoplay: true,
              loop: false,
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
            if ($(item).find('[data-pid_' + pid + ']').length) {
              owl.remove(idx);
              return false;
            }
          }
        );
      }
      debugger;
      if(!$('[data-related] .product-item').length) owl.destroy();
      else  owl.refresh();
    }
  );

})(jQuery);
