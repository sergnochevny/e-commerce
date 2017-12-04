(function ($) {

  $(document).off('.search_action');

  $(document).on('click', 'div.tabs ul.tabNavigation a',
    function() {
      var tabContainers = $('div.tabs div[data-role=tab]');
      tabContainers.hide();
      tabContainers.filter(this.hash).show();
      $('div.tabs ul.tabNavigation li').removeClass('selected');
      $(this).parent('li').addClass('selected');
      $('input[name=current_tab]').val($(this).attr('data-tab_index'));
      return false;
    }
  );

})(jQuery);
