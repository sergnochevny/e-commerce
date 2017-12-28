(function ($) {

  $('div.tabs div[data-role=tab]').hide();
  $('div.tabs div[data-role=tab]').filter($('[data-tab_index=' + $('input[name=current_tab]').val() + ']')[0].hash).show();
  $('div.tabs ul.tabNavigation a').filter('[data-tab_index=' + $('input[name=current_tab]').val() + ']').click();

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

})(window.jQuery || window.$);
