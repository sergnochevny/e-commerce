'use strict';
//
// function addClass(elements, className) {
//   for (var i = 0; i < elements.length; i++) {
//     var element = elements[i];
//     if (element.classList) {
//       element.classList.add(className);
//     } else {
//       element.className += ' ' + className;
//     }
//   }
// }
//
// function welcome() {
//     var el = document.getElementsByTagName('body');
//     addClass([el[0]], 'loaded');
// }
// document.addEventListener("DOMContentLoaded", welcome);
//

jQuery(document).ready(function ($) {


  // $(document).on("click", "a", function (e) {
  //   if($(this).data('link')){
  //     e.preventDefault();
  //     var linkClicked = e.target;
  //     document.addEventListener("unload", $('body').removeClass('loaded').addClass('leaved'));
  //     window.setTimeout(function () {
  //         window.location = linkClicked.href;
  //     }, 1500);
  //
  //     return false;
  //   }
  // });


  $(document).on('click', '[data-search] .panel-heading', function () {
    var body = $(this).next('.panel-body');
    var footer = body.next('.panel-footer');

    if (!body.hasClass('hidden') && !footer.hasClass('hidden')) {
      body.addClass('hidden');
      footer.addClass('hidden');
      $(this).find('.sr-ds').children('.fa').removeClass('fa-rotate-90');
    } else {
      body.removeClass('hidden');
      footer.removeClass('hidden');
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
  $('#commentsubmit').addClass('btn btn-primary');

  /* Style WordPress Default Widgets */
  $('.widget select').addClass('form-control');
  $('.widget table#wp-calendar').addClass('table table-bordered').unwrap().find('th, td').addClass('text-center');
  $('.widget-title .rsswidget img').stop().hide();
  $('.widget-title .rsswidget:first-child').append('<i class="fa fa-rss pull-right">');

  /* Move cross-sell below cart totals on cart page */
  $('.woocommerce .cart-collaterals .cross-sells, .woocommerce-page .cart-collaterals .cross-sells').appendTo('.woocommerce .cart-collaterals, .woocommerce-page .cart-collaterals');
});

(function ($) {
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

  $(document).on('click', '[data-waitloader]',function (event) {
    $('body').waitloader('show');
  });

})(jQuery);