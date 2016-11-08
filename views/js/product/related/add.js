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
      debugger;
      if (this.checked) {
        $(this).parents('label').addClass('checked');
        var product_name = $(this).parents('label').find('.product-desc').text();
        var pid = $(this).attr('data-pid');
        var style = $(this).parents('label').find('figure').attr('style');

        var element = '';
        element += '  <div class="product-item" data-pid_' + pid + '>';
        element += '    <div class="product-inner">';
        element += '      <figure class="product-image-box" style="' + style + '">';
        element += '        <input type="hidden" name="related[]" value="' + pid + '">';
        element += '      </figure>';
        element += '      <span class="product-category">' + product_name + '</span>';
        element += '    </div>';
        element += '  </div>';

        var owl = $('[data-carousel]').data('owlCarousel');
        owl.add(element);
        owl.refresh();
        // $.when($('.related-selected .owl-stage').append(element)).done(
        //   function(){
        //     $('[data-carousel]').trigger('refresh.owl.carousel');
        //   }
        // );
      } else {
        $(this).parents('label').removeClass('checked');
        var pid = $(this).attr('data-pid');
        $('.related-selected .owl-stage').find('data-pid_' + pid).parents('owl-item').remove();
      }
    }
  );

})(jQuery);
