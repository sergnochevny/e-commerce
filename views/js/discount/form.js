'use strict';

(function ($) {

  $(":input").inputmask();

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

  $(":input").inputmask();

  $('body').waitloader('remove');

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

  function postdata(this_, url, data, context, callback) {
    $.postdata(this_, url, data, function (data) {
      if (context !== undefined && context !== null) {
        $.when(context.html(data)).done(
          function () {
            if (callback) callback.call(this_, data);
            $('body').waitloader('remove');
          }
        );
      } else {
        if (callback) callback.call(this_, data);
        $('body').waitloader('remove');
      }
    });
  }

  $('form').on('submit',
    function (event, submitted) {
      event.preventDefault();
      if (submitted) {
        var data = new FormData(this);
        var url = $(this).attr('action');
        var container = $(this).parents('[data-role=form_content]');
        if (container.length == 0) container = $(this).parent();
        postdata(this, url, data, container);
      }
    }
  );

  function evFilterAdd(event) {
    var data = new FormData($('form#edit_form')[0]);
    var url = $('form#edit_form').attr('action');
    data.append('method', $(this).attr('href'));
    var destination = $(this).attr('data-destination');
    var title = $(this).attr('data-title');
    postdata(this, url, data, $('#modal_content'),
      function () {
        $('#modal-title').html(title);
        $('#build_filter').attr('data-destination', destination);
        $('[data-filter-search]').attr('data-destination', destination);
        setEvToFilterSearch();
        $('#modal').modal('show');
      }
    );
  }

  $('#build_filter').on('click',
    function () {
      var destination = $('[data-filter=' + $(this).attr('data-destination') + ']').parent('div');
      var data = new FormData($('form#edit_form')[0]);
      var url = $('form#edit_form').attr('action');
      data.append('method', $(this).attr('href'));
      data.append('type', $(this).attr('data-destination'));
      postdata(this, url, data, destination,
        function () {
          $('#modal').modal('hide');
          setEvToFilter();
        }
      );
    }
  );

  function evRemoveFilterRow(event) {
    $(this).parents('li.selected_item').remove();
  }

  setEvToFilter();

  $('#modal').on('hidden.bs.modal',
    function () {
      $(this).find('#modal_content').empty();
    }
  );

  $('input:radio[name=product_type]').on('change',
    function (event, stop) {
      toggleDetails(stop);
      toggleFabrics(stop);
      if ($(this).is('[data-type]')) {
        var data = new FormData($('form#edit_form')[0]);
        var url = $('form#edit_form').attr('action');
        data.append('method', 'filter');
        data.append('type', $(this).attr('data-type'));
        postdata(this, url, data, $('[data-filter-panel-fabrics]'), setEvToFilter);
      }
    }
  );

  $('input:radio[name=user_type]').on('change',
    function (event, stop) {
      toggleUsers(stop);
      if ($(this).is('[data-type]')) {
        var data = new FormData($('form#edit_form')[0]);
        var url = $('form#edit_form').attr('action');
        data.append('method', 'filter');
        data.append('type', $(this).attr('data-type'));
        postdata(this, url, data, $('[data-filter-panel-users]'), setEvToFilter);
      }
    }
  );

  $('#submit').on('click',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', true);
    }
  );

  $('select#discount_type').on('change',
    function (event, stop) {
      toggleDiscountType(stop);
    }
  );

  $('input#allow_multiple').on('change',
    function (event, stop) {
      toggleMultiple(stop);
    }
  );

  $('input#generate_code').on('change',
    function (event, stop) {
      toggleCouponCode(stop);
    }
  );

  $('input#coupon_code').on('keyup',
    function (event, stop) {
      toggleCouponCode(stop);
    }
  );

  function setEvToFilter() {
    $('span[data-rem_row]').on('click',
      function (event) {
        evRemoveFilterRow.call(this, event);
      }
    );

    $('form#edit_form a[name=edit_filter]').on('click',
      function (event) {
        event.preventDefault();
        evFilterAdd.call(this, event);
      }
    );
  }

  function setEvToFilterSearch() {
    $('[data-filter-search]').on('click',
      function (event) {
        event.preventDefault();
        evFilterSearch.call(this, event);
      }
    );
    $('li.select_item input').on('change',
      function (event) {
        if (!this.checked) {
          $('span[data-rem_row][data-index=' + $(this).val() + ']').trigger('click');
        }
      }
    );
  }

  function evFilterSearch() {
    var data_destination = $(this).attr('data-destination');
    var destination = $('[data-filter=' + data_destination + ']').parent('div');
    var data = new FormData($('form#edit_form')[0]);
    var url = $('form#edit_form').attr('action');
    if ($(this).is('[data-move]')) data.append($(this).attr('data-move'), true);
    data.append('method', $(this).attr('href'));
    data.append('type', data_destination);
    data.append('filter-type', $(this).attr('data-filter-type'));
    postdata(this, url, data, null,
      function (response) {
        var data = JSON.parse(response);
        $.when(
          $(destination).html(data[0]),
          $('#modal_content').html(data[1])
        ).done(
          function () {
            setEvToFilter();
            setEvToFilterSearch();
          }
        );
      }
    );
  }

  function toggleDiscountType(stop) {
    var dtlSlct = document.getElementById('discount_type');
    var dtlSlctSh = document.getElementById('shipping_type');
    var mlt = document.getElementById('allow_multiple');
    var fbtAll = document.getElementById('product_type1');

    if (dtlSlct.selectedIndex == 2) {

      $(dtlSlct).parent('div').removeClass('col-md-6');
      $(dtlSlct).parent('div').addClass('col-md-3');
      $(dtlSlctSh).parent('div').fadeIn();

      mlt.checked = true;
      fbtAll.checked = true;
      if (!stop) {
        $(fbtAll).trigger('change', true);
      }

      toggleFabrics();
    } else {
      $.when($(dtlSlctSh).parent('div').fadeOut()).done(
        function () {
          $(dtlSlct).parent('div').addClass('col-md-6');
          $(dtlSlct).parent('div').removeClass('col-md-3');
        }
      );
    }

    toggleDetailSelect(dtlSlct, false);

  }

  function toggleCouponCode(stop) {
    var txtCoupon = document.getElementById('coupon_code');
    var chckCoupon = document.getElementById('generate_code');
    var chckMlt = document.getElementById('allow_multiple');
    var fbtAll = document.getElementById('product_type1');
    if ((txtCoupon.value.length > 0) || (chckCoupon.checked)) {
      chckMlt.checked = true;
      fbtAll.checked = true;
      if (!stop) {
        $(fbtAll).trigger('change', true);
      }
      toggleFabrics();
    }

  }

  function toggleDetailSelect(dtlSlct, disable) {
    dtlSlct.disabled = disable;
  }

  function toggleFabrics(stop) {
    $('[data-filter-panel-fabrics]').empty();
  }

  function toggleDetails(stop) {
    var fbtSlct = document.getElementById('product_type1');
    var dtlSlct = document.getElementById('discount_type');
    if (!fbtSlct.checked) {
      dtlSlct.selectedIndex = 1;
      var txtCoupon = document.getElementById('coupon_code');
      var chckCoupon = document.getElementById('generate_code');
      $(txtCoupon).val('');
      chckCoupon.checked = false;
      if (!stop) {
        $(dtlSlct).trigger('change', true);
        $(chckCoupon).trigger('change', true);
      }
    }
  }

  function toggleMultiple(stop) {
    var multiple = document.getElementById("allow_multiple");
    var dtlSlct = document.getElementById('discount_type');
    if (!multiple.checked) {
      dtlSlct.selectedIndex = 1;
      var txtCoupon = document.getElementById('coupon_code');
      var chckCoupon = document.getElementById('generate_code');
      $(txtCoupon).val('');
      chckCoupon.checked = false;
      if (!stop) {
        $(dtlSlct).trigger('change', true);
        $(chckCoupon).trigger('change', true);
      }
    }
  }

  function toggleUsers() {
    $('[data-filter-panel-users]').empty();
  }

  $('input[type=text]').textinput();
  $('input[type=textarea]').textinput();
  $('input[type=number]').textinput();
  $('input[type=email]').textinput();
  $('input[type=password]').textinput();

  $('textarea').textinput();
  $('select').selectmenu();

})(jQuery);
