(function ($) {
  'use strict';

  $('#date-from').datepicker({
    dateFormat: 'mm/dd/yy',
    onSelect: function (dateText, inst) {
      $('#date-to').datepicker('option', 'minDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
    }
  });

  $('#date-to').datepicker({
    dateFormat: 'mm/dd/yy',
    onSelect: function (dateText, inst) {
      $('#date-from').datepicker('option', 'maxDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
    }
  });

  $('[data-restrict]').restrict();
  $("input[data-inputmask]").inputmask();

})(window.jQuery || window.$);
