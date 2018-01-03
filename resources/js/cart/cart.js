(function ($) {

  var base_url = $('#base_url').val();

  $(document).on('change', 'input[data-role=quantity]', function (event) {
    event.preventDefault();
    var v = $(this).val();
    var input = this;
    var url = base_url + 'cart/change_product';
    var pid = $(this).parents('[data-block=cart_item]').attr('data-pid');
    var parent = $(this).parents('[data-block=cart_item]');

    $('body').waitloader('show');

    $.get(url, {pid: pid, qnt: v}, function (answer) {
      try {
        var data = JSON.parse(answer);
        if (data.product) {
          $(document).trigger('destroy_spinner');

          $.when($(parent).replaceWith(data.product)).done(function () {
            $(document).trigger('init_spinner');
            $('body').waitloader('remove');
            $('[data-block=subtotal_items]').load(base_url + 'cart/items_amount');
            $('[data-block=subtotal]').load(base_url + 'cart/amount');
            $(document).trigger('calc_shipping_total');
          });
        }
        if (data.msg) {
          $.when(
            $(data.msg).appendTo('.main-content')
          ).done(
            function () {
              $('#modal').modal('show');
              $('#modal').on('hidden.bs.modal', function () {
                $(this).remove();
              });
            }
          );
        }
      } catch (e) {
        $('.main-content').html(data);
      }
    });
  }).on('click.confirm_action', ".popup a.close", function (event) {
    event.preventDefault();
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
  }).on('click.confirm_action', "#confirm_no", function (event) {
    event.preventDefault();
    $(".popup a.close").trigger('click');
  }).on('click', '[data-block=del_product_cart]',
    function (event) {
      event.preventDefault();
      var url = $(this).attr('href');
      var pid = $(this).parents('[data-block=cart_item]').attr('data-pid');
      var parent = $(this).parents('[data-block=cart_item]');
      var spinner = $(parent).find('input[data-role=quantity]');

      $("#confirm_action").on('click.confirm_action',
        function (event) {
          event.preventDefault();
          $.get(url,
            {pid: pid},
            function (data) {
              $.when($(document).trigger('destroy_spinner')).done(
                function () {
                  $.when($(parent).remove()).done(
                    function () {
                      if ($('[data-row=items]').length > 0) {
                        $(document).trigger('init_spinner');
                        $('[data-block=subtotal_items]').load(base_url + 'cart/items_amount');
                      } else {
                        $('[data-block=row_subtotal]').remove();
                        $('[data-block=row_subtotal_items]').remove();
                        $('[data-block=coupon_section]').remove();
                        $('[data-block=products-cart-list]').remove();
                        if ($('[data-row=samples]').length > 0) {
                          $('[data-block=subtotal_samples_items]').load(base_url + 'cart/samples_amount');
                          $('[data-block=samples_legend]').load(base_url + 'cart/samples_legend');
                        }
                      }
                      if (($('[data-row=items]').length > 0) || ($('[data-row=samples]').length > 0)) {
                        $('[data-block=subtotal]').load(base_url + 'cart/amount');
                      } else {
                        $(document).trigger('remove_inputs');
                      }
                      $(document).trigger('calc_shipping_total');
                      $("#confirm_dialog").removeClass('overlay_display');
                      $("#confirm_action").off('click.confirm_action');
                    }
                  );
                }
              );
            }
          );
        }
      );

      $("#confirm_dialog").addClass('overlay_display');

    }
  ).on('click', '[data-block=del_sample_cart]',
    function (event) {
      event.preventDefault();
      var url = $(this).attr('href');
      var pid = $(this).parents('[data-block=sample_item]').attr('data-pid');
      var parent = $(this).parents('[data-block=sample_item]');

      $("#confirm_action").on('click.confirm_action', function (event) {
        event.preventDefault();
        $.get(url, {pid: pid}, function (data) {
          $.when($(parent).remove()).done(function () {
            if ($('[data-row=samples]').length > 0) {
              $('[data-block=subtotal_samples_items]').load(base_url + 'cart/samples_amount');
            } else {
              $('[data-block=row_subtotal]').remove();
              $('[data-block=row_subtotal_samples]').remove();
              $('[data-block=samples_legend]').remove();
              $('[data-block=samples_table]').remove();
            }
            if (($('[data-row=items]').length > 0) || ($('[data-row=samples]').length > 0)) {
              $('[data-block=subtotal]').load(base_url + 'cart/amount');
            } else {
              $(document).trigger('remove_inputs');
            }
            $(document).trigger('calc_shipping_total');
            $("#confirm_dialog").removeClass('overlay_display');
            $("#confirm_action").off('click.confirm_action');
          });
        });
      });

      $("#confirm_dialog").addClass('overlay_display');

    }
  ).on('remove_inputs', function (event) {
    event.preventDefault();
    $('[data-block=div_subtotal_table]').remove();
    $('[data-block=products-cart-list]').remove();
    $('[data-block=proceed_button]').remove();
    $('[data-block=coupon_section]').remove();
    $('.page-title').text('Your cart is empty, yet...');
    $('.cont-shop').text('Go shopping')
  }).on('init_spinner', function (event) {
    event.preventDefault();
    var whole;
    $('input[data-role=quantity]').each(
      function (idx) {
        whole = $(this).attr('data-whole');
        if (whole === 1) {
          $(this).spinner({
            max: 1000000,
            min: 1,
            spin: function (event, ui) {
              $(this).val(ui.value);
              $(this).trigger('change');
            }
          });
        } else {
          $(this).spinner({
            max: 1000000,
            min: 1,
            step: 0.05,
            numberFormat: 'n',
            spin: function (event, ui) {
              $(this).val(ui.value).trigger('change');
            }
          });
        }
      }
    );
  }).on('destroy_spinner', function (event) {
    event.preventDefault();
    $('input[data-role=quantity]').each(function (idx) {
      $(this).spinner("destroy");
    });
  }).on('calc_shipping_total',
    function (event) {
      event.preventDefault();
      var url = base_url + 'cart/shipping_calc';
      var stotal_url = base_url + 'cart/get_subtotal_ship';
      var data = new FormData();
      if ($('[data-block=select_ship]').length > 0) {
        var coupon = '';
        if ($('[data-block=coupon_code]').length > 0) coupon = $('[data-block=coupon_code]').val();
        var ship = $('[data-block=select_ship]').val();
        var roll = 0;
        if ($('[data-block=roll]').length > 0) roll = $('[data-block=roll]')[0].checked ? 1 : 0;
        data.append('ship', ship);
        data.append('roll', roll);
        data.append('coupon', coupon);
      }

      if ($('[data-block=express_samples]').length > 0) {
        data.append('express_samples', $('[data-block=express_samples]')[0].checked ? 1 : 0);
      }
      $.postdata(this, url, data,
        function (data) {
          $('[data-block=shipping]').html(data);
          $('[data-block=subtotal_ship]').load(stotal_url);
          $(document).trigger('calc_total');
        }
      );
    }
  ).on('calc_total', function (event) {
    event.preventDefault();
    var url = base_url + 'cart/coupon_total_calc';
    var data = new FormData();
    data.append('emty', true);
    $.postdata(this, url, data, function (data) {
      $('[data-block=coupon_total]').html(data);
    });
  }).on('change', '[data-block=select_ship]', function (event) {
    event.preventDefault();
    $(document).trigger('calc_shipping_total');
  }).on('change', '[data-block=roll]', function (event) {
    event.preventDefault();
    $(document).trigger('calc_shipping_total');
  }).on('change', '[data-block=express_samples]', function (event) {
    event.preventDefault();
    $(document).trigger('calc_shipping_total');
  }).on('click', '[data-block=apply_coupon]', function (event) {
    event.preventDefault();
    $(document).trigger('calc_shipping_total');
  }).on('click', '[data-block=proceed_button]', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $.get(url, {}, function (data) {
      $.when($('#content').html(data)).done(function () {
        $('html, body').stop().animate({scrollTop: 0}, 1000);
      });
    });
  }).on('click', '[data-block=proceed_agreem_button]', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $.get(url, {}, function (data) {
      $.when($('#content').html(data)).done(function () {
        $('html, body').stop().animate({scrollTop: 0}, 1000);
      });
    });
  }).on('change', '[data-block=agreeterm]', function (event) {
    event.preventDefault();
    $('[data-block=container_proceed_pay]').toggle(this.checked);
  }).on('submit', '[data-block=paypal_form]', function (event) {
    event.preventDefault();
    var url = base_url + 'cart/pay_mail';
    $('body').waitloader('show');
    $.get(url);
  }).ready(function (event) {
    $(this).trigger('init_spinner');
  });

})(window.jQuery || window.$);
