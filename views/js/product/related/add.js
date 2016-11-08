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
      if(this.checked) $(this).parents('label').addClass('checked');
      else $(this).parents('label').removeClass('checked');
    }
  );

})(jQuery);
