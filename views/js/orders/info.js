'use strict';
(function ($) {

    $('#dateFrom').datepicker({
        dateFormat: 'mm/dd/yy',
        minDate: 0,
        onClose: function (selectedDate) {
            $("#txtStartDate").datepicker("option", "dateFormat", "dd-mm-yy", selectedDate);
        }
    });

    $('#status_select').val('<?= $status_code ?>');

    $('#track_code, #dateFrom').focus(function () {
        $(this).css('border', '2px solid rgb(238, 238, 238)')
    });

    function send_request(form) {
        var url = form.attr('action');
        $.post(
            url, form.serialize(),
            function (data) {
                var result = JSON.parse(data);
                if (result['result'] = 0) {
                    $('.danger').stop().show();
                    setTimeout(function () {
                        $('.danger').text('An error occurred, please, try again later').css('display', 'none');
                    }, 8000);
                } else {
                    if (result['status'] == 0) {
                        $('.status').text('In process');
                    } else {
                        $('.status').text('Completed');
                    }
                    $('.track_code').text(result['track_code']);
                    $('.end_date').text(result['end_date']);
                    $('#status_select').val(result['status']);
                    $('.success').stop().show();
                    setTimeout(function () {
                        $('.success').text('Data updates have been successful').css('display', 'none');
                    }, 8000);

                }
            }
        )
    }

    $("#edit_orders_info").on('submit',

        function (event) {
            event.preventDefault();

            if ($('#status_select option:selected').val() == 1) {
                if ($('#track_code').val() == '') {
                    $("#track_code").css("border", "2px solid red");
                    setTimeout(function () {
                        $('.danger').text('Track code is empty').css('display', 'none');
                    }, 8000);
                }
                if ($('#dateFrom').val() == '') {
                    $("#dateFrom").css("border", "2px solid red");
                    setTimeout(function () {
                        $('.danger').text('Date of delivery is missing').css('display', 'none');
                    }, 8000);
                }
                send_request($(this));
                return true;
            }
            else {
                send_request($(this));
            }
        }
    );
})(jQuery);