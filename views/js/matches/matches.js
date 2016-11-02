'use strict';

(function ($) {

    var a = 1,
        base_url = $('#base_url').val();

    $(document).ready(function (event) {
        setTimeout(function () {
            $('html,body').stop().animate({
                scrollTop: $('#content').offset().top
            }, 2000);
        }, 300);
    });

    $('#dragZoneArea > img').mousedown(function (eventObject) {
        $(this).css("z-index", a++);
    }).draggable({
        containment: "#dragZoneArea",
        start: function (event, ui) {
            $(this).css("z-index", a++);
        }
    });

    $(document).on('dblclick', "img#product_img_holder",function (event) {
        var pid = $(this).attr('data-id');
        window.location = base_url + 'shop/product?pid=' + pid;
    });

    $('.deleteDragImg').droppable({
        hoverClass: "ui-state-hover",
        drop: function (event, ui) {
            var pid = $(ui.draggable).attr('data-id'),
                url = base_url + 'matches/delete';
            $('#content').waitloader('show');
            $.post(
                url,
                {pid: pid},
                function (data) {
                    $(ui.draggable).remove();
                    $('#content').waitloader('remove');
                }
            )
        }
    });

    $('.detailsDragImg').droppable({
        hoverClass: "ui-state-hover",
        drop: function (event, ui) {
            $('#content').waitloader('show');
            var pid = $(ui.draggable).attr('data-id');
            window.location = base_url + 'shop/product?pid=' + pid+'&back=matches';
        }
    });

    $('#clear_matches').on('click', function (ev) {
        ev.preventDefault();
        var url = $(this).attr('href');
        $('#content').waitloader('show');
        var data = new FormData();
        $.post(url, data, function (data) {
            $('img#product_img_holder').each(function () {
                $(this).remove();
            });
            $('#content').waitloader('remove');

        });
    });

    $('#all_to_basket').on('click',
        function (ev) {
            ev.preventDefault();
            var products = [];
            $('#dragZoneArea').children('img').each(function (idx, element) {
                products.push($(this).attr('data-id'));
            });

            var data = JSON.stringify(products),
                url = $(this).attr('href'),
                load_url = base_url + 'cart/amount';

            $('#content').waitloader('show');

            $.post(url, {data: data},function (data) {
                $.when(
                    $('#content').waitloader('remove'),
                    $(data).appendTo('#content'),
                    $('span#cart_amount').load(load_url)
                ).done(function () {
//                          if($('span#cart_amount').length>0){
                    $('#clear_matches').trigger('click');
                    var buttons = {
                        "Basket": function () {
                            $(this).remove();
                            $('#content').waitloader('show');
                            window.location = base_url + 'cart';
                        }
                    };
                    $('#msg').dialog({
                        draggable: false,
                        dialogClass: 'msg',
                        title: 'Add All to Basket',
                        modal: true,
                        zIndex: 10000,
                        autoOpen: true,
                        width: '700',
                        resizable: false,
                        buttons: buttons,
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });
                    $('.msg').css('z-index', '10001');
                    $('.ui-widget-overlay').css('z-index', '10000');
//                          }
                });

            });
        });

})(jQuery);