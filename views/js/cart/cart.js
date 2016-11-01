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

    $.get(url,
      {pid: pid, qnt: v},
      function (answer) {
        var data = JSON.parse(answer);
        if (data.product) {
          $(document).trigger('destroy_spinner');

          $.when($(parent).replaceWith(data.product))
            .done(function () {
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
              $('#msg').dialog({
                draggable: false,
                dialogClass: 'msg',
                title: 'Basket',
                modal: true,
                zIndex: 10000,
                autoOpen: true,
                width: '500',
                resizable: false,
                close: function (event, ui) {
                  $(this).remove();
                }
              });
              $('.msg').css('z-index', '10001');
              $('.ui-widget-overlay').css('z-index', '10000');

            });

        }
      });
  });

  $(document).on('click.confirm_action', ".popup a.close", function (event) {
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
  });

  $(document).on('click.confirm_action', "#confirm_no", function (event) {
    $(".popup a.close").trigger('click');
  });

  $(document).on('click', '.del_product_cart',
    function (event) {
      event.preventDefault();
      debugger;
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
  );

  $(document).on('click', '.del_sample_cart',
    function (event) {
      debugger;
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
  );

  $(document).on('remove_inputs', function () {
    $('[data-block=div_subtotal_table]').remove();
    $('[data-block=products-cart-list]').remove();
    $('[data-block=proceed_button]').remove();
    $('[data-block=coupon_section]').remove();
    $('.page-title').text('Your cart is empty, yet...');
    $('.cont-shop').text('Go shopping')
  });

  $(document).on('init_spinner', function () {
    var whole;
    $('input[data-role=quantity]').each(
      function (idx) {
        whole = $(this).attr('data-whole');
        if (whole == 1) {
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
  });

  $(document).on('destroy_spinner', function () {
    $('input[data-role=quantity]').each(function (idx) {
      $(this).spinner("destroy");
    });
  });

  $(document).ready(function (event) {
    $(this).trigger('init_spinner');
  });

  $(document).on('calc_shipping_total',
    function () {
      debugger;
      var url = base_url + 'cart/shipping_calc';
      var stotal_url = base_url + 'cart/get_subtotal_ship';
      if ($('[data-block=select_ship]').length > 0) {
        var coupon = '';
        if ($('[data-block=coupon_code]').length > 0) coupon = $('[data-block=coupon_code]').val();
        var ship = $('[data-block=select_ship]').val();
        var roll = 0;
        if ($('[data-block=roll]').length > 0) roll = $('[data-block=roll]')[0].checked ? 1 : 0;
        var data = {ship: ship, roll: roll, coupon: coupon};
      }

      if ($('[data-block=express_samples]').length > 0) {
        var express_samples = $('[data-block=express_samples]')[0].checked ? 1 : 0;
        var data = {express_samples: express_samples};
      }
      $.post(url, data,
        function (data) {
        debugger;
          $('[data-block=shipping]').html(data);
          $('[data-block=subtotal_ship]').load(stotal_url);
          $(document).trigger('calc_total');
        }
      );
    }
  );

  $(document).on('calc_total', function () {
    var url = base_url + 'cart/coupon_total_calc';
    var data = {};
    $.post(url, data, function (data) {
      $('[data-block=coupon_total]').html(data);
    });
  });

  $(document).on('change', '[data-block=select_ship]', function (event) {
    $(document).trigger('calc_shipping_total');
  });
  $(document).on('change', '[data-block=roll]', function (event) {
    $(document).trigger('calc_shipping_total');
  });
  $(document).on('change', '[data-block=express_samples]', function (event) {
    $(document).trigger('calc_shipping_total');
  });
  $(document).on('click', '[data-block=apply_coupon]', function (event) {
    $(document).trigger('calc_shipping_total');
  });
  $(document).on('click', '[data-block=proceed_button]', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $.get(url, {}, function (data) {
      $.when($('#content').html(data))
        .done(function () {
          $('html, body').stop().animate({scrollTop: 0}, 1000);
        });
    });
  });

  $(document).on('click', '[data-block=proceed_agreem_button]', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $.get(url, {}, function (data) {
      $.when($('#content').html(data))
        .done(function () {
          $('html, body').stop().animate({scrollTop: 0}, 1000);
        });
    });
  });

  $(document).on('change', '[data-block=agreeterm]', function (event) {
    debugger;
    $('#container_proceed_pay').toggle(this.checked);
  });

  $(document).on('submit', '[data-block=paypal_form]', function (event) {
    var url = base_url + 'cart/pay_mail';
    $('body').waitloader('show');
    $.get(url);
  });

})(jQuery);