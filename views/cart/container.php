<body
    class="page page-id-1707 page-template-default woocommerce-cart woocommerce-page header-large ltr sticky-header-yes wpb-js-composer js-comp-ver-4.11.1 vc_responsive small-sticky">


<link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>' type='text/css' media='all'/>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div id="cart_main_container" class="container">
            <?= isset($content)?$content:'';?>
        </div>
    </div>
</div>
<div id="confirm_dialog" class="overlay"></div>
<div class="popup">
    <div class="fcheck"></div>
    <a class="close" title="close"></a>

    <div class="b_cap_cod_main">
        <p style="color: black;">You confirm the removal ?</p>
        <br/>
        <center>
            <a id="confirm_action">
                <input type="button" value="Yes confirm" class="button"/></a>
            <a id="confirm_no">
                <input type="button" value="No" class="button"/></a>
        </center>
    </div>
</div>


<script type="text/javascript">
    (function ($) {
        var base_url = '<?= _A_::$app->router()->UrlTo('/');?>';

        $(document).on('change', 'input[data-role=quantity]',
            function (event) {
                event.preventDefault();
                var v = $(this).val();
//                var v = parseInt($(this).val());
//                if (isNaN(v) || (v < 1)) {
//                    v = 1;
//                }
//                $(this).val(v);

                $('body').waitloader('show');
                var input = this;
                var url = base_url + 'cart/change_product';
                var p_id = $(this).parents('tr.cart_item').attr('data-pid');
                var parent = $(this).parents('tr.cart_item');

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

                                }
                            );

                        }
                    }
                );
            }
        );

        $(document).on('click.confirm_action', ".popup a.close",
            function (event) {
                $("#confirm_action").off('click.confirm_action');
                $("#confirm_dialog").removeClass('overlay_display');
            }
        );

        $(document).on('click.confirm_action', "#confirm_no",
            function (event) {

                $(".popup a.close").trigger('click');
            }
        );

        $(document).on('click', '#del_product_cart',
            function (event) {
                event.preventDefault();

                var url = $(this).attr('href');
                var p_id = $(this).parents('tr.cart_item').attr('data-pid');
                var parent = $(this).parents('tr.cart_item');
                var spinner = $(parent).find('input[data-role=quantity]');

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

        $(document).on('click', '#del_sample_cart',
            function (event) {
                event.preventDefault();
                var url = $(this).attr('href');
                var p_id = $(this).parents('tr.sample_item').attr('data-pid');
                var parent = $(this).parents('tr.sample_item');

                $("#confirm_action").on('click.confirm_action',
                    function (event) {
                        event.preventDefault();
                        $.get(url,
                            {p_id: p_id},
                            function (data) {
                                $.when($(parent).remove()).done(
                                    function () {
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
                                    }
                                );
                            }
                        );
                    }
                );

                $("#confirm_dialog").addClass('overlay_display');

            }
        );

        $(document).on('remove_inputs',
            function () {
                $('#div_subtotal_table').remove();
                $('#proceed_button').remove();
                $('#coupon_section').remove();
            }
        );

        $(document).on('init_spinner', function () {
            var whole;
            $('input[data-role=quantity]').each(
                function (idx) {
                    whole = $(this).attr('data-whole');
                    if (whole == 1) {
                        $(this).spinner(
                            {
                                max: 1000000,
                                min: 1,
                                spin: function (event, ui) {
                                    $(this).val(ui.value);
                                    $(this).trigger('change');
                                }
                            }
                        );
                    } else {
                        $(this).spinner(
                            {
                                max: 1000000,
                                min: 1,
                                step: 0.05,
                                numberFormat: 'n',
                                spin: function (event, ui) {
                                    $(this).val(ui.value);
                                    $(this).trigger('change');
                                }
                            }
                        );
                    }
                }
            );
        });

        $(document).on('destroy_spinner', function () {
            $('input[data-role=quantity]').each(
                function (idx) {
                    $(this).spinner("destroy");
                }
            );
        });

        $(document).ready(
            function (event) {
                $(document).trigger('init_spinner');
            }
        );

        $(document).on('calc_shipping_total',
            function () {
                var url = base_url + 'cart/shipping_calc';
                var stotal_url = base_url + 'cart/get_subtotal_ship';
                if ($('#select_ship').length > 0) {
                    var coupon = '';
                    if ($('#coupon_code').length > 0){
                        coupon = $('#coupon_code').val();
                    }
                    var ship = $('#select_ship').val();
                    var roll = 0;
                    if ($('#roll').length > 0) {
                        roll = $('#roll')[0].checked ? 1 : 0;
                    }
                    var data = {ship: ship, roll: roll, coupon: coupon};
                }
                if ($('#express_samples').length > 0) {
                    var express_samples = $('#express_samples')[0].checked ? 1 : 0;
                    var data = {express_samples: express_samples};
                }
                $.post(
                    url,
                    data,
                    function (data) {
                        $('#shipping').html(data);
                        $('#subtotal_ship').load(stotal_url);
                        $(document).trigger('calc_total');
                    }
                );
            }
        );

        $(document).on('calc_total',
            function () {
                var url = base_url + 'cart/coupon_total_calc';
                var data= {};
                $.post(
                    url,
                    data,
                    function (data) {
                        $('#coupon_total').html(data);
                    }
                );
            }
        );

        $(document).on('change', '#select_ship',
            function (event) {
                $(document).trigger('calc_shipping_total');
            }
        );

        $(document).on('change', '#roll',
            function (event) {
                $(document).trigger('calc_shipping_total');
            }
        );

        $(document).on('change', '#express_samples',
            function (event) {
                $(document).trigger('calc_shipping_total');
            }
        );

        $(document).on('click','#apply_coupon',
            function(event){
                $(document).trigger('calc_shipping_total');
            }
        );

        $(document).on('click','#proceed_button',
            function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                $.get(
                    url, {},
                    function(data) {
                        $.when($('#cart_main_container').html(data))
                            .done(
                                function(){
                                    $('html, body').stop().animate({scrollTop: 0}, 1000);
                                }
                            );
                    }
                );
            }
        );

        $(document).on('click','#proceed_agreem_button',
            function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                $.get(
                    url, {},
                    function(data) {
                        $.when($('#cart_main_container').html(data))
                            .done(
                                function(){
                                    $('html, body').stop().animate({scrollTop: 0}, 1000);
                                }
                            );
                    }
                );
            }
        );

        $(document).on('change','#agreeterm',
            function(event) {
                $('#container_proceed_pay').toggle(this.checked);
            }
        );

        $(document).on('submit','#paypal_form',
            function(event) {
                var url = base_url + 'cart/pay_mail';
                $('#container_proceed_pay').waitloader('show');                
                $.get(url);
            }
        );

    })(jQuery);

</script>



