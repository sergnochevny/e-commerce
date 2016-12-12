(function ($) {

  function _postdata(this_, url, data, callback) {
    $.postdata(this_, url, data,
      function (data) {
        $.when($('[data-edit_products]').html(data)).done(
          function(){
            if(callback) callback.call(this_);
          }
        );
      }
    );
  }

  $(document).off('.search_action');

  $.change_button_text();

    var tabContainers = $('div.tabs div[data-role=tab]');
    tabContainers.hide().filter(':first').show();

  $(document).on('click', 'div.tabs ul.tabNavigation a',
    function() {
      tabContainers.hide();
      tabContainers.filter(this.hash).show();
      $('div.tabs ul.tabNavigation a').removeClass('selected');
      $(this).addClass('selected');
      return false;
    }
  );

  $('div.tabs ul.tabNavigation a').filter(':first').click();

})(jQuery);
