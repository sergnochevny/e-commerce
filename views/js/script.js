'use strict';

jQuery(document).ready(function ($) {

  if ($(window).width() < 485) {
    $.each($('[data-viewport]'),
      function (idx, element) {
        $(element).text($(element).attr('data-vp_change_content'))
      }
    );
  }

  $('#menu-button').on('click', function () {
    $(document.body).toggleClass('menu-open');
  });

  $(document).on('click', '.search-call', function () {
    $(this).children('form').toggleClass('hidden');
  });

  $(document).on('click', '[data-search] .panel-heading', function () {
    var body = $(this).next('.panel-body');
    var footer = body.next('.panel-footer');

    if (!body.hasClass('hidden') && !footer.hasClass('hidden')) {
      body.addClass('hidden');
      footer.addClass('hidden');
      $(this).find('.sr-ds').children('.fa').removeClass('fa-rotate-90');
      $(this).removeClass('collapsed');
    } else {
      body.removeClass('hidden');
      footer.removeClass('hidden');
      $(this).addClass('collapsed');
      $(this).find('.sr-ds').children('.fa').addClass('fa-rotate-90');
    }
  });

  var body = $('body');
  /* Keyboard image navigation */
  if (body.hasClass('attachment-jpg') ||
    body.hasClass('attachment-jpeg') ||
    body.hasClass('attachment-jpe') ||
    body.hasClass('attachment-gif') ||
    body.hasClass('attachment-png')
  ) {
    $(document).keydown(function (e) {
      var url = false;
      if (e.which === 37) {  // Left arrow key code
        url = $('.image-navigation .nav-previous a').attr('href');
      }
      else if (e.which === 39) {  // Right arrow key code
        url = $('.image-navigation .nav-next a').attr('href');
      }
      if (url && ( !$('textarea, input').is(':focus') )) {
        window.location = url;
      }
    });
  }

  /* Style Comments */
  $('#commentsubmit').addClass('button btn-primary');

  /* Style WordPress Default Widgets */
  $('.widget select').addClass('form-control');
  $('.widget table#wp-calendar').addClass('table table-bordered').unwrap().find('th, td').addClass('text-center');
  $('.widget-title .rsswidget img').stop().hide();
  $('.widget-title .rsswidget:first-child').append('<i class="fa fa-rss pull-right">');

  /* Move cross-sell below cart totals on cart page */
  $('.woocommerce .cart-collaterals .cross-sells, .woocommerce-page .cart-collaterals .cross-sells').appendTo('.woocommerce .cart-collaterals, .woocommerce-page .cart-collaterals');
});

(function ($) {
  $.extend({
    /*$.post function replacement*/
    postdata: function (this_, url, data, callback) {
      $('body').waitloader('show');
      $.ajax({
        type: 'POST',
        url: url,
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
          if (callback) {
            $.when(callback.call(this_, data)).done(function () {
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
  });

  $.fn.extend({
    waitloader: function (action) {
      var wait_loader_fa = '<div class="ui-widget-overlay" id="wait_loader">' +
        '<i class="fa fa-spinner fa-pulse fa-4x"></i>' +
        '</div>';
      switch (action) {
        case 'show':
          if ($('#wait_loader').length == 0) {
            $(wait_loader_fa).appendTo(this).css('z-index', '9999');
          }
          break;
        case 'remove':
          if ($('#wait_loader').length > 0) {
            $('#wait_loader').remove();
          }
          break;
      }
    }
  });

  $(document).on('click', '#b_search', function (event) {
    $('#f_search').trigger('submit');
  });

  $(function () {
    //$("a.zoom").prettyPhoto({
    //	hook: "data-rel",
    //	social_tools: !1,
    //	theme: "pp_woocommerce",
    //	horizontal_padding: 20,
    //	opacity: .8,
    //	deeplinking: !1
    //});

    $("a[data-rel^='prettyPhoto']").prettyPhoto({
      hook: "data-rel",
      social_tools: '',
      theme: "pp_woocommerce",
      //	horizontal_padding: 20,
      //	opacity: .8,
      //	show_title: false,
      //  allow_resize: true,
      allow_expand: true,
      default_width: 700
    });
  });

  $(document).on('click', '[data-waitloader]', function (event) {
    $('body').waitloader('show');
  });

  $(document).on('focus', 'input[type=text], input[type=textarea], textarea',
    function (event) {
      $(this).parent().addClass('focus')
    }
  );
  $(document).on('focusout', 'input[type=text], input[type=textarea], textarea',
    function (event) {
      $(this).parent().removeClass('focus')
    }
  );

})(jQuery);