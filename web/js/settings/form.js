(function ($) {

  $('div.tabs div[data-role=tab]').hide();
  $('div.tabs div[data-role=tab]').filter($('[data-tab_index='+$('input[name=current_tab]').val()+']')[0].hash).show();
  $('div.tabs ul.tabNavigation a').filter('[data-tab_index='+$('input[name=current_tab]').val()+']').click();

  $("ul[data-sortable]").sortable({
    connectWith: "[data-sortable]",
    stop: function (event, ui) {
      if (($(ui.item).parents('.available_fields').length) &&
        ($(this).is('.selected_fields'))) {
        $(ui.item).find('input[type=checkbox]').removeAttr('checked');
        $(ui.item).find('.move-arrows').addClass('hidden');
      }
      if (($(ui.item).parents('.selected_fields').length) &&
        ($(this).is('.available_fields'))) {
        $(ui.item).find('input[type=checkbox]').attr('checked', 'checked');
        $(ui.item).find('.move-arrows').removeClass('hidden');
      }
      $(ui.item).removeClass("ui-selected");
    },
    change: function (event, ui) {
      if (($(ui.placeholder).parents('.available_fields').length) &&
        ($(ui.item).parents('.available_fields').length)) {
        return false;
      }
    }
  }).disableSelection();

  $("[data-append]").on('click', function (event) {
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

  $("[data-remove]").on('click', function (event) {
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

  $('[data-move_up]').on("click", function () {
    var element = $(this).parents('li');
    var element_prev = element.prev();
    element.fadeOut(500, function () {
      element.insertBefore(element_prev);
      element.fadeIn(500);
    });
    $("ul[data-sortable]").trigger('sortupdate');
  });

  $('[data-move_down]').on("click", function () {
    var element = $(this).parents('li');
    var element_next = element.next();
    element.fadeOut(500, function () {
      element.insertAfter(element_next);
      element.fadeIn(500);
    });
    $("ul[data-sortable]").trigger('sortupdate');
  });

})(jQuery);
