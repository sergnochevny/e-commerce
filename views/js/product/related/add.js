(function ($) {

  debugger;

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
        element += '  <div class="product-item" data-pid_' + pid + '>';
        element += '    <div class="product-inner">';
        element += '      <figure class="product-image-box" style="' + style + '">';
        element += '        <input type="hidden" name="related[]" value="' + pid + '"/>';
        element += '      </figure>';
        element += '      <span class="product-category">' + product_name + '</span>';
        element += '    </div>';
        element += '  </div>';

        var idx = owl.add(element);
        owl.refresh();
        $(this).attr('data-carousel_idx', idx);
      } else {
        $(this).parents('label').removeClass('checked');
        var owl_items = owl.items();
        $.each(owl_items,
          function (idx, item) {
            if($(item).find('[data-pid_'+pid+']').length){
              owl.remove(idx);
              return false;
            }
          }
        );
        $('.related-selected .owl-stage').find('data-pid_' + pid).parents('owl-item').remove();
      }
    }
  );

})(jQuery);
