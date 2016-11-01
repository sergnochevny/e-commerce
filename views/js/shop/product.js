'use strict';

(function ($) {
  var base_url = $('#base_url').val(),
    back_url = $('#back_url').val();

  $('a#add_cart').on('click', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $('#content').waitloader('show');
    $.get(url, {}, function (answer) {
      var data = JSON.parse(answer);
      $.when(
        $('span#cart_amount').html(data.sum),
        $(data.msg).appendTo('#content'),
        $('#add_cart').fadeOut(),
        $('#view_cart').fadeIn()
      ).done(function () {
        $('#content').waitloader('remove');

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
          title: 'Added to Basket',
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
    $('#content').waitloader('show');
    $.get(url, {}, function (answer) {
      var data = JSON.parse(answer);
      $.when(
        $('span#cart_amount').html(data.sum),
        $(data.msg).appendTo('#content')
      ).done(function () {
        $('#content').waitloader('remove');

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
          title: 'Added to Basket',
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

  $(document).ready(
    function (event) {
      $('a#add_matches').on('click', function (ev) {
        ev.preventDefault();
        $('#content').waitloader('show');
        var url = $(this).attr('href');
        $.post(url, {}, function (data) {
          var answer = JSON.parse(data);
          $.when(
            $('#content').waitloader('remove'),
            $(answer.data).appendTo('#content')
          ).done(function () {
            var buttons = {
              "Continue shopping": function () {
                $('#content').waitloader('show');
                if ($('.a_search').length > 0) {
                  $('.a_search').trigger('click');
                } else
                  window.location = back_url;
              }
            };

            if (answer.added == 1) {
              $('#add_matches').fadeOut();
              $('#view_matches').fadeIn();
              $.extend(buttons, {
                "Matches": function () {
                  $(this).remove();
                  $('#content').waitloader('show');
                  window.location = base_url + 'matches';
                }
              });
            }

            $('#msg').dialog({
              draggable: false,
              dialogClass: 'msg',
              title: 'Added to Matches',
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
    });

})(jQuery);
