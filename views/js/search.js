
(function($){


    $('#date-from').datepicker({
        dateFormat: 'mm/dd/yy',
        onSelect: function (dateText, inst) {
            $('#dateTo').datepicker('option', 'minDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
        }
    });

    $('#date-to').datepicker({
        dateFormat: 'mm/dd/yy',
        onSelect: function (dateText, inst) {
            $('#dateFrom').datepicker('option', 'maxDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
        }
    });


})(jQuery);