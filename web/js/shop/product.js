'use strict';

(function ($) {
  var base_url = $('#base_url').val();
  var back_url = $('#back_url').attr('href');
  var related = $('[data-related]');
  var related_href = $('[data-href_related]');
  if (related_href.length) {
    $(related).waitloader('show');
    var url = related_href.val();
    related.load(url,
      function () {
        $('[data-carousel]').owlCarousel({
          responsive: {0: {items: 1}, 461: {items: 2}, 992: {items: 3}},
          margin: 15,
          nav: true,
          navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
          autoplay: true,
          loop: false,
          rewind: true,
          autoplayHoverPause: false,
          dots: true
        });
      }
    );
  }

  $(document).on('click.confirm_action', ".popup a.close", function (event) {
    $("#confirm_dialog").removeClass('overlay_display');
    $('body').css('overflow', 'auto');
  });

  $('#add_cart').on('click', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $('body').waitloader('show');
    $.get(url, {}, function (answer) {
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

        if ($('#modal').length > 0) {
          $('#modal').modal('show');
          $('body').waitloader('remove');
        }
      });
    });
  });

  $('#add_samples_cart').on('click', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    $('body').waitloader('show');
    $.get(url, {}, function (answer) {
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

        if ($('#modal').length > 0) {
          $('#modal').modal('show');
          $('body').waitloader('remove');
        }
      });
    });
  });

  $('#add_matches').on('click', function (ev) {
    ev.preventDefault();
    $('body').waitloader('show');
    var url = $(this).attr('href');
    var data = new FormData();
    $.postdata(this, url, data, function (data) {
      var answer = JSON.parse(data);
      $.when(
        $(answer.data).appendTo('#content')
      ).done(function () {

        if (answer.added == 1) {
          $('#add_matches').stop().hide();
          $('#view_matches').stop().show().addClass('btn-row');
        }

        $('#modal').on('hidden.bs.modal',
          function () {
            $(this).remove();
          }
        );

        if ($('#modal').length > 0) {
          $('#modal').modal('show');
          $('body').waitloader('remove');
        }
      });
    });
  });

  $(document).on('click', "#continue", function (event) {
    event.preventDefault();
    if (back_url) {
      $('#content').waitloader('show');
      window.location = back_url;
    }
  });

  $('#add_favorites').on('click', function (ev) {
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

        $('#add_favorites').stop().hide();
        $('#view_favorites').stop().show().addClass('btn-row');

        $('#modal').on('hidden.bs.modal',
          function () {
            $(this).remove();
          }
        );

        if ($('#modal').length > 0) {
          $('#modal').modal('show');
          $('body').waitloader('remove');
        }
      });
    });
  });

})(jQuery);
