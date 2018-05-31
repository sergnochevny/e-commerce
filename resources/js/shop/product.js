(function ($) {
  'use strict';

  var base_url = $('#base_url').val();
  var back_url = $('#back_url').attr('href');

  $('[data-carousel]').owlCarousel({
    responsive: {0: {items: 1}, 461: {items: 2}, 992: {items: 3}},
    margin: 15,
    nav: true,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    autoplay: true,
    loop: false,
    rewind: true,
    autoplayHoverPause: true,
    autoplayTimeout: 2000,
    dots: true
  });

  $(document).on('click.confirm_action', ".popup a.close", function (event) {
    $("#confirm_dialog").removeClass('overlay_display');
    $('body').css('overflow', 'auto');
  }).on('click', '#add_cart', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $('body').waitloader('show');
    $.get(url, {}, function (answer) {
      try {
        var data = JSON.parse(answer);
        $.when(
          $(data.msg).appendTo('#content'),
          $('span#cart_amount').html(data.sum)
        ).done(function () {

          $('#add_cart').stop().hide().addClass('visible-item');
          $('#view_cart').stop().show().removeClass('visible-item');

          $('#modal').on('hidden.bs.modal',
            function () {
              $(this).remove();
            }
          );

          $('body').waitloader('remove');
          if ($('#modal').length > 0) {
            $('#modal').modal('show');
          }
        });
      } catch (e) {
        $('#content').html(data);
      }
    });
  }).on('click', '#add_samples_cart', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $('body').waitloader('show');
    $.get(url, {}, function (answer) {
      try {
        var data = JSON.parse(answer);
        $.when(
          $(data.msg).appendTo('#content'),
          $('span#cart_amount').html(data.sum)
        ).done(function () {

          $('#add_samples_cart').stop().hide().addClass('visible-item');

          $('#modal').on('hidden.bs.modal',
            function () {
              $(this).remove();
            }
          );

          $('body').waitloader('remove');
          if ($('#modal').length > 0) {
            $('#modal').modal('show');
          }
        });
      } catch (e) {
        $('#content').html(data);
      }
    });
  }).on('click', '#add_matches', function (ev) {
    ev.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    var data = new FormData();
    $.postdata(this, url, data, function (data) {
      try {
        var answer = JSON.parse(data);
        $.when(
          $(answer.data).appendTo('#content')
        ).done(function () {

          if (answer.added === 1) {
            $('#add_matches').stop().hide();
            $('#view_matches').stop().show().addClass('btn-row');
          }

          $('#modal').on('hidden.bs.modal',
            function () {
              $(this).remove();
            }
          );

          $('body').waitloader('remove');
          if ($('#modal').length > 0) {
            $('#modal').modal('show');
          }
        });
      } catch (e) {
        $('#content').html(data);
      }
    });
  }).on('click', '.pp_gallery a', function (event) {
    debugger;
    event.preventDefault();
    return false;
  }).on('click', "#continue", function (event) {
    event.preventDefault();
    if (back_url) {
      $('body').waitloader('show');
      window.location = back_url;
    }
  }).on('click', '#add_favorites', function (ev) {
    ev.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    var pid = $(this).attr('data-pid');
    var data = new FormData();
    data.append('pid', pid);
    $.postdata(this, url, data, function (data) {
      $.when(
        $(data).appendTo('#content')
      ).done(function () {

        $('#add_favorites').stop().hide();
        $('#view_favorites').stop().show().addClass('btn-row');

        $('#modal').on('hidden.bs.modal',
          function () {
            $(this).remove();
          }
        );

        $('body').waitloader('remove');
        if ($('#modal').length > 0) {
          $('#modal').modal('show');
        }
      });
    });
  });

  $("a[data-rel^='prettyPhoto']").prettyPhoto({
    hook: "data-rel",
    social_tools: '',
    theme: "pp_woocommerce",
    deeplinking: false,
    default_width: 840
  });

})(window.jQuery || window.$);
