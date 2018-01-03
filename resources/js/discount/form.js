(function ($) {
  'use strict';

  $("input").inputmask();

  $.danger_remove(8000);

  $('#discount_comment1').charCounter({
    charsLimit: 255,
    charsLimitOutputBlock: '#discount_comment1_counter_output',
    outputNotificationBlock: '#discount_comment1_counter_notification'
  });
  $('#discount_comment2').charCounter({
    charsLimit: 255,
    charsLimitOutputBlock: '#discount_comment2_counter_output',
    outputNotificationBlock: '#discount_comment2_counter_notification'
  });
  $('#discount_comment3').charCounter({
    charsLimit: 255,
    charsLimitOutputBlock: '#discount_comment3_counter_output',
    outputNotificationBlock: '#discount_comment3_counter_notification'
  });

  $('#dateFrom').datepicker({
    dateFormat: 'mm/dd/yy',
    onSelect: function (dateText, inst) {
      $('#dateTo').datepicker('option', 'minDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
    }
  });

  $('#dateTo').datepicker({
    dateFormat: 'mm/dd/yy',
    onSelect: function (dateText, inst) {
      $('#dateFrom').datepicker('option', 'maxDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
    }
  });

  $('form#edit_form').init_input();

})(window.jQuery || window.$);
