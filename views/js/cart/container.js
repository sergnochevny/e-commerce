'use strict';

(function ($) {
    var base_url = $('#base_url').val();

    $(document).on('change', 'input[data-role=quantity]',function (event) {
        event.preventDefault();
        var v = $(this).val(),
            input = this,
            url = base_url + 'cart/change_product',
            p_id = $(this).parents('tr.cart_item').attr('data-pid'),
            parent = $(this).parents('tr.cart_item');

        $('body').waitloader('show');

        $.get(url,
            {p_id: p_id, qnt: v},
            function (answer) {
                var data = JSON.parse(answer);
                if (data.product) {
                    $(document).trigger('destroy_spinner');

                    $.when($(parent).replaceWith(data.product))
                        .done(function () {
                            $(document).trigger('init_spinner');
                            $('.main-content').waitloader('remove');
                            $('#subtotal_items').load(base_url + 'cart/items_amount');
                            $('#subtotal').load(base_url + 'cart/amount');
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

    $(document).on('click.confirm_action', ".popup a.close",function (event) {
        $("#confirm_action").off('click.confirm_action');
        $("#confirm_dialog").removeClass('overlay_display');
    });

    $(document).on('click.confirm_action', "#confirm_no",function (event) {
        $(".popup a.close").trigger('click');
    });

    $(document).on('click', '.del_product_cart',
        function (event) {
            event.preventDefault();

            var url = $(this).attr('href'),
                p_id = $(this).parents('tr.cart_item').attr('data-pid'),
                parent = $(this).parents('tr.cart_item'),
                spinner = $(parent).find('input[data-role=quantity]');

            $("#confirm_action").on('click.confirm_action',
                function (event) {
                    event.preventDefault();
                    $.get(url,
                        {p_id: p_id},
                        function (data) {
                            $.when($(document).trigger('destroy_spinner')).done(
                                function () {
                                    $.when($(parent).remove()).done(
                                        function () {
                                            if ($('[data-row=items]').length > 0) {
                                                $(document).trigger('init_spinner');
                                                $('#subtotal_items').load(base_url + 'cart/items_amount');
                                            } else {
                                                $('#row_subtotal').remove();
                                                $('#row_subtotal_items').remove();
                                                $('#coupon_section').remove();
                                                if ($('[data-row=samples]').length > 0) {
                                                    $('#subtotal_samples_items').load(base_url + 'cart/samples_amount');
                                                    $('#samples_legend').load(base_url + 'cart/samples_legend');
                                                }
                                            }
                                            if (($('[data-row=items]').length > 0) || ($('[data-row=samples]').length > 0)) {
                                                $('#subtotal').load(base_url + 'cart/amount');
                                            } else
                                                $(document).trigger('remove_inputs');
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
            event.preventDefault();
            var url = $(this).attr('href'),
                p_id = $(this).parents('tr.sample_item').attr('data-pid'),
                parent = $(this).parents('tr.sample_item');

            $("#confirm_action").on('click.confirm_action', function (event) {
                    event.preventDefault();
                    $.get(url, {p_id: p_id}, function (data) {
                    $.when($(parent).remove()).done(function () {
                        if ($('[data-row=samples]').length > 0) {
                            $('#subtotal_samples_items').load(base_url + 'cart/samples_amount');
                        } else {
                            $('#row_subtotal').remove();
                            $('#row_subtotal_samples').remove();
                            $('#samples_legend').remove();
                            $('#samples_table').remove();
                        }
                        if (($('[data-row=items]').length > 0) || ($('[data-row=samples]').length > 0)) {
                            $('#subtotal').load(base_url + 'cart/amount');
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

    $(document).on('remove_inputs',function () {
        $('#div_subtotal_table').remove();
        $('#proceed_button').remove();
        $('#coupon_section').remove();
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

    $(document).on('calc_shipping_total',function () {
        var url = base_url + 'cart/shipping_calc',
            stotal_url = base_url + 'cart/get_subtotal_ship',
            express_samplesObj = $('#express_samples'),
            rollObj = $('#roll'),
            coupon_codeObj = $('#coupon_code'),
            ship = '',
            roll = 0,
            express_samples = '',
            data = {ship: ship, roll: roll},
            coupon = '';

        if ($('#select_ship').length > 0) {
            if (coupon_codeObj.length > 0){
                coupon = coupon_codeObj.val();
            }
            if (rollObj.length > 0) {
                roll = rollObj[0].checked ? 1 : 0;
            }
            if (coupon.trim().length > 0){
                data = {ship: ship, roll: roll, coupon: coupon};
            }
        }
        if (express_samplesObj.length > 0) {
            express_samples = express_samplesObj[0].checked ? 1 : 0;
            data = {express_samples: express_samples};
        }
        $.post( url, data,function (data) {
            $('#shipping').html(data);
            $('#subtotal_ship').load(stotal_url);
            $(document).trigger('calc_total');
        });
    });

    $(document).on('calc_total',function () {
        var url = base_url + 'cart/coupon_total_calc',
            data= {};
        $.post( url, data,function (data) {
            $('#coupon_total').html(data);
        });
    });

    $(document).on('change', '#select_ship',function (event) {
        $(document).trigger('calc_shipping_total');
    });

    $(document).on('change', '#roll',function (event) {
        $(document).trigger('calc_shipping_total');
    }).on('change', '#express_samples',function (event) {
        $(document).trigger('calc_shipping_total');
    }).on('click','#apply_coupon',function(event){
        $(document).trigger('calc_shipping_total');
    }).on('click','#proceed_button', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $.get( url, {}, function(data) {
            $.when($('#cart_main_container').html(data))
                .done(function(){
                    $('html, body').stop().animate({scrollTop: 0}, 1000);
                });
        });
    });

    $(document).on('click','#proceed_agreem_button', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $.get( url, {}, function(data) {
            $.when($('#cart_main_container').html(data))
                .done(function(){
                    $('html, body').stop().animate({scrollTop: 0}, 1000);
                });
        });
    });

    $(document).on('change','#agreeterm', function(event) {
        $('#container_proceed_pay').toggle(this.checked);
    });

    $(document).on('submit','#paypal_form', function(event) {
        var url = base_url + 'cart/pay_mail';
        $('#container_proceed_pay').waitloader('show');
        $.get(url);
    });

})(jQuery);