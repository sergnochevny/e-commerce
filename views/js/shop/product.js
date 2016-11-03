'use strict';

(function ($) {
  var base_url = $('#base_url').val(),
    back_url = $('#back_url').val();

  function postdata(url, data, callback) {
    $('body').waitloader('show');
    var this_ = this;
    $.ajax({
      type: 'POST',
      url: url,
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: function (data) {
        if (callback) {
          $.when(callback.call(this_, data)).done(function(){
            $('body').waitloader('remove');
          });
        } else {
          $('body').waitloader('remove');
        }
      },
      error: function (xhr, str) {
        alert('Error: ' + xhr.responseCode);
        $('body').waitloader('remove');
      },
    });
  }


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
    postdata.call(this, url, data, function (data) {
      var answer = JSON.parse(data);
      $.when(
        $('body').waitloader('remove'),
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

  $('a#add_favorites').on('click', function (ev) {
    ev.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    var pid = $(this).attr('data-pid');
    var data = new FormData();
    data.append('pid', pid);
    postdata.call(this, url, data, function (data) {
      $('body').waitloader('show');
      $.when(
        $(data).appendTo('#content')
      ).done(function () {
        var buttons = {
          "Continue shopping": function () {
            $('body').waitloader('show');
            window.location = back_url;
          }
        };

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
        $('body').waitloader('remove');

      });
    });
  });

})(jQuery);
