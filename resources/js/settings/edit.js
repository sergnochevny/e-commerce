(function ($) {

  $(document).off('.search_action');

  $(document).on('click', 'div.tabs ul.tabNavigation a',
    function (event) {
      event.preventDefault();
      var tabContainers = $('div.tabs div[data-role=tab]');
      tabContainers.hide();
      tabContainers.filter(this.hash).show();
      $('div.tabs ul.tabNavigation li').removeClass('selected');
      $(this).parent('li').addClass('selected');
      $('input[name=current_tab]').val($(this).attr('data-tab_index'));
      return false;
    }
  );

  $(document).on('click', "[data-append]", function (event) {
    event.preventDefault();
    var element = $(this).parents('li');
    element.find('input[type=checkbox]').attr('checked', 'checked');
    element.fadeOut(500, function () {
      element.appendTo('.selected_fields');
      element.find('.move-arrows').removeClass('hidden');
      element.fadeIn(500);
    });
    $("ul[data-sortable]").trigger('sortupdate');
  });

  $(document).on('click', "[data-remove]", function (event) {
    event.preventDefault();
    var element = $(this).parents('li');
    element.find('input[type=checkbox]').removeAttr('checked');
    element.fadeOut(500, function () {
      element.appendTo('.available_fields');
      element.find('.move-arrows').addClass('hidden');
      element.fadeIn(500);
    });
    $("ul[data-sortable]").trigger('sortupdate');
  });

  $(document).on("click", '[data-move_up]', function () {
    var element = $(this).parents('li');
    var element_prev = element.prev();
    element.fadeOut(500, function () {
      element.insertBefore(element_prev);
      element.fadeIn(500);
    });
    $("ul[data-sortable]").trigger('sortupdate');
  });

  $(document).on("click", '[data-move_down]', function () {
    var element = $(this).parents('li');
    var element_next = element.next();
    element.fadeOut(500, function () {
      element.insertAfter(element_next);
      element.fadeIn(500);
    });
    $("ul[data-sortable]").trigger('sortupdate');
  });

})(window.jQuery || window.$);
