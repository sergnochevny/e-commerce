'use strict';

(function ($) {

    $('#discount_starts').datepicker({
        dateFormat: 'mm/dd/yy',
        onSelect: function (dateText, inst) {
            $('#discount_ends').datepicker(
                'option',
                'minDate',
                new Date(
                    inst.selectedYear,
                    inst.selectedMonth,
                    inst.selectedDay
                )
            );
        }
    });

    $('#discount_ends').datepicker({
        dateFormat: 'mm/dd/yy',
        onSelect: function (dateText, inst) {
            $('#discount_starts').datepicker(
                'option',
                'maxDate',
                new Date(
                    inst.selectedYear,
                    inst.selectedMonth,
                    inst.selectedDay
                )
            );
        }
    });

})(jQuery);