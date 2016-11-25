'use strict';
(function ($) {
  $(":input").inputmask();

  var throwDangerAlert = function (notification) {
      $('.notification').text(notification).addClass('alert-danger').removeClass('hidden')
    },
    throwSuccessAlert = function (notification) {
      $('.notification').text(notification).addClass('alert-success').removeClass('hidden')
    },
    hideAlert = function () {
      setTimeout(function () {
        $('.notification').text('').removeClass('alert-danger').removeClass('alert-success').addClass('hidden');
      }, arguments[0] && arguments[0] > 0 ? arguments[0] : 8000);
    };


  $('#dateFrom').datepicker({
    dateFormat: 'mm/dd/yy',
    minDate: 0,
    onClose: function (selectedDate) {
      $("#txtStartDate").datepicker("option", "dateFormat", "mm/dd/yy", selectedDate);
    }
  });

  function send_request(form) {
    var data = new FormData(form);
    $.postdata(this, form.attr('action'), data, function (data) {
      var result = JSON.parse(data);
      if (result['result'] = 0) {
        throwDangerAlert('An error occurred, please, try again later');
        hideAlert();
      } else {
        throwSuccessAlert('Data updates have been successful');
        hideAlert();
      }
    })
  }

  $("#edit_order_info").on('click', function (event) {
    var track = $('#track_code'),
      date = $('#dateFrom');

    if ($('#status_select').children('option:selected').val() == 1) {

      if (track.val().length < 1) {
        track.css("border", "2px solid red");
        throwDangerAlert('Track code is empty');
        hideAlert();
      }
      if (date.val() == '') {
        date.css("border", "2px solid red");
        throwDangerAlert('Date of delivery is missing');
        hideAlert();
      }
      send_request($('#edit_orders_info'));
    }
    else {
      send_request($('#edit_orders_info'));
    }
  });

})(jQuery);