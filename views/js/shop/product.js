'use strict';

(function ($) {
  var base_url = $('#base_url').val();
  var back_url = $('#back_url').attr('href');

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
        $(data.msg).appendTo('#content'),
        $('#add_cart').stop().hide().addClass('visible-item'),
        $('#view_cart').stop().show().removeClass('visible-item')
      ).done(function () {

        $('body').waitloader('remove');
        $("#confirm_dialog").addClass('overlay_display');
        $('#modal').modal('show');

        var buttons = {
          "Basket": function () {
            $(this).remove();
            $('body').waitloader('show');
            window.location = base_url + 'cart';
          }
        };

        $('#msg').dialog({
          draggable: false,
          dialogClass: 'msg',
          title: 'Add to Basket',
          modal: true,
          zIndex: 10000,
          autoOpen: true,
          width: '500',
          resizable: false,
          buttons: buttons,
          close: function (event, ui) {
            $(this).remove();
          }
        });
        $('.msg').css('z-index', '10001');
        $('.ui-widget-overlay').css('z-index', '10000');

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
        $(data.msg).appendTo('#content'),
        $('#add_samples_cart').stop().hide().addClass('visible-item')
      ).done(function () {
        $('body').waitloader('remove');
        $('#modal').modal('show');

        var buttons = {
          "Basket": function () {
            $(this).remove();
            $('body').waitloader('show');
            window.location = base_url + 'cart';
          }
        };

        $('#msg').dialog({
          draggable: false,
          dialogClass: 'msg',
          title: 'Add to Basket',
          modal: true,
          zIndex: 10000,
          autoOpen: true,
          width: '500',
          resizable: false,
          buttons: buttons,
          close: function (event, ui) {
            $(this).remove();
          }
        });
        $('.msg').css('z-index', '10001');
        $('.ui-widget-overlay').css('z-index', '10000');

      });
    });
  });

  $('a#add_matches').on('click', function (ev) {
    ev.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    var data = new FormData();
    $.postdata(this, url, data, function (data) {
      var answer = JSON.parse(data);
      $.when(
        $(answer.data).appendTo('#content')
      ).done(function () {
        var buttons = {
          "Continue shopping": function () {
            $('body').waitloader('show');
            window.location = back_url;
          }
        };

        if (answer.added == 1) {
          $('#add_matches').stop().hide().addClass('visible-item');
          $('#view_matches').stop().show().removeClass('visible-item').addClass('btn-row');
          $.extend(buttons, {
            "Matches": function () {
              $(this).remove();
              $('body').waitloader('show');
              window.location = base_url + 'matches';
            }
          });
        }

        $('body').waitloader('remove');
        $('#modal').modal('show');

        $('#msg').dialog({
          draggable: false,
          dialogClass: 'msg',
          title: 'Add to Matches',
          modal: true,
          zIndex: 10000,
          autoOpen: true,
          width: '500',
          resizable: false,
          buttons: buttons,
          close: function (event, ui) {
            $(this).remove();
          }
        });
        $('.msg').css('z-index', '10001');
        $('.ui-widget-overlay').css('z-index', '10000');
      });
    });
  });

  $(document).on('click', "#continue", function (event) {
    event.preventDefault;
    if (back_url) window.location = back_url;
  });

  $('a#add_favorites').on('click', function (ev) {
    ev.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    var pid = $(this).attr('data-pid');
    var data = new FormData();
    data.append('pid', pid);
    $.postdata(this, url, data, function (data) {
      $('body').waitloader('show');
      $.when(
        $(data).appendTo('#content')
      ).done(function () {

        $('#modal').on('hidden.bs.modal',
          function () {
            $(this).remove();
          }
        );

        if($('#modal').length>0){
          $('#modal').modal('show');
          $('body').waitloader('remove');
        }
      });
    });
  });

})(jQuery);
