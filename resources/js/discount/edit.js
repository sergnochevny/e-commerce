(function ($) {
  'use strict';

  $('body').waitloader('remove');

  function evFilterAdd() {
    var edit_form = $('form#edit_form'),
      data = new FormData(edit_form[0]),
      url = edit_form.attr('action');
    data.append('method', $(this).attr('href'));
    var destination = $(this).attr('data-destination');
    var title = $(this).attr('data-title');
    postdata(this, url, data, $('#modal_content'),
      function () {
        $('#modal_content').init_input();
        $('#modal-title').html(title);
        $('#modal-title').init_input();
        $('#build_filter').attr('data-destination', destination);
        $('[data-filter-search]').attr('data-destination', destination);
        $('#modal').modal('show');
      }
    );
  }

  function evRemoveFilterRow() {
    $(this).parents('li.selected_item').remove();
  }

  function evFilterSearch() {
    var data_destination = $(this).attr('data-destination'),
      destination = $('[data-filter=' + data_destination + ']').parent('div'),
      edit_form = $('form#edit_form'),
      data = new FormData(edit_form[0]),
      url = edit_form.attr('action');
    if ($(this).is('[data-move]')) data.append($(this).attr('data-move'), true);
    data.append('method', $(this).attr('href'));
    data.append('type', data_destination);
    data.append('filter-type', $(this).attr('data-filter-type'));
    postdata(this, url, data, null,
      function (response) {
        try {
          var data = JSON.parse(response);
          $(destination).html(data[0]);
          $('#modal_content').html(data[1])
        } catch (e) {
          $(destination).html(response);
        }
      }
    );
  }

  function postdata(this_, url, data, context, callback) {
    $.postdata(this_, url, data, function (data) {
      if (context !== undefined && context !== null) {
        $.when($(context[0]).html(data)).done(
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

  function toggleDiscountType(stop) {
    var dtlSlct = document.getElementById('discount_type');
    var dtlSlctSh = document.getElementById('shipping_type');
    var mlt = document.getElementById('allow_multiple');
    var fbtAll = document.getElementById('product_type1');

    if (dtlSlct.selectedIndex === 2) {

      $(dtlSlct).parent('div').removeClass('col-md-6');
      $(dtlSlct).parent('div').addClass('col-md-3');
      $(dtlSlctSh).parent('div').fadeIn();

      mlt.checked = true;
      fbtAll.checked = true;
      if (!stop) {
        $(fbtAll).trigger('change', [true]);
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
        $(fbtAll).trigger('change', [true]);
      }
      toggleFabrics();
    }

  }

  function toggleDetailSelect(dtlSlct, disable) {
    dtlSlct.disabled = disable;
  }

  function toggleFabrics() {
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
        $(dtlSlct).trigger('change', [true]);
        $(chckCoupon).trigger('change', [true]);
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
        $(dtlSlct).trigger('change', [true]);
        $(chckCoupon).trigger('change', [true]);
      }
    }
  }

  function toggleUsers() {
    $('[data-filter-panel-users]').empty();
  }

  $(document).on('submit', 'form#edit_form',
    function (event, submitted) {
      event.preventDefault();
      if (submitted) {
        var data = new FormData(this);
        var url = $(this).attr('action');
        var container = $(this).parents('[data-role=form_content]');
        if (container.length === 0) container = $(this).parent();
        postdata(this, url, data, container);
      }
    }
  ).on('click', '#build_filter',
    function () {
      var destination = $('[data-filter=' + $(this).attr('data-destination') + ']').parent('div'),
        edit_form = $('form#edit_form'),
        data = new FormData(edit_form[0]),
        url = edit_form.attr('action');
      data.append('method', $(this).attr('href'));
      data.append('type', $(this).attr('data-destination'));
      postdata(this, url, data, destination,
        function () {
          $('#modal').modal('hide');
        }
      );
    }
  ).on('hidden.bs.modal', '#modal',
    function () {
      $(this).find('#modal_content').empty();
    }
  ).on('change', 'input:radio[name=product_type]',
    function (event, stop) {
      var edit_form = $('form#edit_form');
      toggleDetails(stop);
      toggleFabrics();
      if ($(this).is('[data-type]')) {
        var data = new FormData(edit_form[0]);
        var url = edit_form.attr('action');
        data.append('method', 'filter');
        data.append('type', $(this).attr('data-type'));
        postdata(this, url, data, $('[data-filter-panel-fabrics]'));
      }
    }
  ).on('change', 'input:radio[name=user_type]',
    function (event, stop) {
      var edit_form = $('form#edit_form');
      toggleUsers(stop);
      if ($(this).is('[data-type]')) {
        var data = new FormData(edit_form[0]);
        var url = edit_form.attr('action');
        data.append('method', 'filter');
        data.append('type', $(this).attr('data-type'));
        postdata(this, url, data, $('[data-filter-panel-users]'));
      }
    }
  ).on('click', '#submit',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
    }
  ).on('change', 'select#discount_type',
    function (event, stop) {
      toggleDiscountType(stop);
    }
  ).on('change', 'input#allow_multiple',
    function (event, stop) {
      toggleMultiple(stop);
    }
  ).on('change', 'input#generate_code',
    function (event, stop) {
      toggleCouponCode(stop);
    }
  ).on('keyup', 'input#coupon_code',
    function (event, stop) {
      toggleCouponCode(stop);
    }
  ).on('click', 'span[data-rem_row]',
    function (event) {
      evRemoveFilterRow.call(this, event);
    }
  ).on('click', 'form#edit_form a[name=edit_filter]',
    function (event) {
      event.preventDefault();
      evFilterAdd.call(this, event);
    }
  ).on('click', '[data-filter-search]',
    function (event) {
      event.preventDefault();
      evFilterSearch.call(this, event);
    }
  ).on('change', 'li.select_item input',
    function (event) {
      event.preventDefault();
      if (!this.checked) {
        $('span[data-rem_row][data-index=' + $(this).val() + ']').trigger('click');
      }
    }
  );

})(window.jQuery || window.$);
