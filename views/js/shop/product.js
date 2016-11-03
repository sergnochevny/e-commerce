'use strict';

(function ($) {
    var base_url = $('#base_url').val(),
        back_url = $('#back_url').val();

    $(document).on('click.confirm_action', ".popup a.close", function (event) {
        $("#confirm_dialog").removeClass('overlay_display');
        $('body').css('overflow', 'auto');
    });

    $('a#add_cart').on('click', function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $('body').waitloader('show');
        $.get(url, {}, function (answer) {
            var data = JSON.parse(answer);
            $.when(
                $('span#cart_amount').html(data.sum),
                $('#modal_content').html(data.msg),
                $('#add_cart').stop().hide().addClass('visible-item'),
                $('#view_cart').stop().show().removeClass('visible-item')
            ).done(function () {
                $('body').waitloader('remove');
                $("#confirm_dialog").addClass('overlay_display');
                $('#modal').modal('show');
            });
        });
    });

    $('a#add_samples_cart').on('click', function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $('body').waitloader('show');
        $.get(url, {}, function (answer) {
            var data = JSON.parse(answer);
            $.when(
                $('span#cart_amount').html(data.sum),
                $('#modal_content').html(data.msg),
                $('#add_samples_cart').stop().hide().addClass('visible-item')
            ).done(function () {
                $('body').waitloader('remove');
                $("#confirm_dialog").addClass('overlay_display');
                $('#modal').modal('show');
            });
        });
    });

    $('#modal').on('hidden.bs.modal', function () {
        $("#confirm_dialog").removeClass('overlay_display');
    });

    $('a#add_matches').on('click', function (ev) {
        ev.preventDefault();
        $('body').waitloader('show');
        var url = $(this).attr('href');
        var data = new FormData();
        $.post(url, data, function (data) {
            var answer = JSON.parse(data);
            $.when(
                $('body').waitloader('remove'),
                $('#modal_content').html(data.msg)
            ).done(function () {

                if (answer.added == 1) {
                    $('#add_matches').stop().hide().addClass('visible-item');
                    $('#view_matches').stop().show().removeClass('visible-item').addClass('btn-row');
                    $('.matches').removeClass('hidden').prev('.to-cart').addClass('hidden');
                }

                $('body').waitloader('remove');
                $("#confirm_dialog").addClass('overlay_display');
                $('#modal').modal('show');


            });
        });
    });

})(jQuery);
