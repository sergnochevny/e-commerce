window.addEventListener('pagehide', function (event) {
  var loader = document.getElementById('wait_loader');
  if (loader) {
    loader.parentNode.removeChild(loader);
  }
}, false);

var change_text = false;

(function ($) {
  'use strict';

  var _waitloader_counter = 0;

  $.extend({
    danger_remove: function (timeout) {
      var alert_container = $('.alert-container');
      var danger = $('.danger');
      if (danger.length) {
        danger.stop().show();
        setTimeout(function () {
          danger.remove();
          alert_container.remove();
        }, timeout);
      }
    },
    change_button_text: function (force) {
      if (force) change_text = false;
      if ($(window).width() < 485) {
        if (!change_text) {
          $.each($('[data-viewport]'),
            function (idx, element) {
              change_text = true;
              var old_text = $(element).text();
              $(element).text($(element).attr('data-vp_change_content'));
              $(element).attr('data-vp_change_content', old_text);
            }
          );
        }
      } else {
        if (change_text) {
          $.each($('[data-viewport]'),
            function (idx, element) {
              change_text = false;
              var old_text = $(element).text();
              $(element).text($(element).attr('data-vp_change_content'));
              $(element).attr('data-vp_change_content', old_text);
            }
          );
        }
      }
    }
    ,
    /*$.post function replacement*/
    postdata: function (this_, url, data, success, error, loader) {
      if (typeof loader === 'undefined') loader = true;
      if (loader) $('body').waitloader('show');
      $.ajax({
        type: 'POST',
        url: url,
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
          if (success && (typeof success === 'function')) {
            $.when(success.call(this_, data)).done(function () {
              if (loader) $('body').waitloader('remove');
            });
          } else {
            if (loader) $('body').waitloader('remove');
          }
        },
        error: function (xhr, str) {
          if (error && (typeof error === 'function')) {
            $.when(error.call(this_, xhr, str)).done(function () {
              alert('Error: ' + xhr.responseCode);
              if (loader) $('body').waitloader('remove');
            });
          } else {
            alert('Error: ' + xhr.responseCode);
            if (loader) $('body').waitloader('remove');
          }
        }
      });
    }
  });

  $.fn.extend({
    init_input: function () {
      $(this).find('input[type=text]').each(
        function () {
          var options = {};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          $(this).textinput(options)
        });
      $(this).find('input[type=textarea]').each(
        function () {
          var options = {};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          $(this).textinput(options)
        });
      $(this).find('input[type=number]').each(
        function () {
          var options = {};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          $(this).textinput(options)
        });
      $(this).find('input[type=email]').each(
        function () {
          var options = {};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          $(this).textinput(options)
        });
      $(this).find('input[type=password]').each(
        function () {
          var options = {};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          $(this).textinput(options);
        });
      $(this).find('input[type=url]').each(
        function () {
          var options = {};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          $(this).textinput(options)
        });

      $(this).find('textarea').each(
        function () {
          var options = {};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          $(this).textinput(options)
        }
      );
      $(this).find('select').each(
        function () {
          var options = {appendTo: $(this).parent()};
          $.each($(this).data('events'),
            function (name, event) {
              options[name] = function (ev, ui) {
                $.each(event, function (key, item) {
                  item.handler.call(ev.target, ev);
                });
              }
            }
          );
          if (!$(this).is('[multiple]')) {
            $(this).selectmenu(options);
          } else {
            if ($(this).is('[data-placeholder]')) {
              options = $.extend(options, {
                placeholder: $(this).data('placeholder')
              });
            }
            $(this).multiselect(options);
          }
        }
      );
    },
    waitloader: function (action) {
      var _wait_loader_fa = '<div class="ui-widget-overlay" id="wait_loader" style="display: none">' +
        '<i class="fa fa-spinner fa-pulse fa-4x"></i>' +
        '</div>';

      var _loader = $('.loader'),
        _waitloader = $('#wait_loader');
      switch (action) {
        case 'show':
          _waitloader_counter += 1;
          if (_loader.length > 0) {
            _loader.fadeIn();
          } else {
            if (!_waitloader.length) {
              $.when($(_wait_loader_fa).appendTo(this).css('z-index', '100000000'))
                .done(function () {
                  $(_wait_loader_fa).fadeIn();
                });
            }
          }
          break;
        case 'remove':
          _waitloader_counter -= 1;
          if (_waitloader_counter <= 0) {
            _waitloader_counter = 0;
            if (_loader.length > 0) {
              _loader.fadeOut(2000);
            } else {
              if (_waitloader.length > 0) {
                $.when(_waitloader.fadeOut(2000))
                  .done(function () {
                    _waitloader.remove();
                  });
              }
            }
          }
          break;
      }
    },

    restrict: function () {
      return this.each(function () {
        if ((this.type && 'number' === this.type.toLowerCase()) || (this.type && 'text' === this.type.toLowerCase())) {
          $(this).on('change', function () {
            var _self = this;
            var v = parseFloat(_self.value);
            var min = parseFloat(_self.min);
            var max = parseFloat(_self.max);
            if ($(_self).is('[relation-min]') && !isNaN(parseFloat($($(_self).attr('relation-min'))[0].value)))
              min = parseFloat($($(_self).attr('relation-min'))[0].value);
            if ($(_self).is('[relation-max]') && !isNaN(parseFloat($($(_self).attr('relation-max'))[0].value)))
              max = parseFloat($($(_self).attr('relation-max'))[0].value);
            if (v >= min && v <= max) {
              _self.value = v;
            } else {
              _self.value = v < min ? min : max;
            }
          });
        }
      });
    }
  });

  $(window).on('resize', function () {
    $.change_button_text();
  });

  $(document).on('submit', '#f_search',
    function (event) {
      event.preventDefault();
      event.stopPropagation();
      var data = new FormData(this);
      var url = $(this).attr('action');
      $('body').waitloader('show');
      $.postdata(this, url, data,
        function (data) {
          $('#slider').remove();
          $('#content').html(data);
          $('body').waitloader('remove');
        }
      );
    }
  ).on('click', '#b_search', function (event) {
    $('#f_search').trigger('submit');
  }).on('click', '#menu-button', function () {
    $(document.body).toggleClass('menu-open');
  }).on('click', '.search-call', function () {
    $(this).children('form').toggleClass('hidden');
  }).on('click', '[data-search] .panel-heading', function (event) {
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
  }).on('click', '[data-waitloader]', function (event) {
    if (!$(this).is('[disabled]')) $('body').waitloader('show');
  }).on('focus', 'input[type=text], input[type=textarea], input[type=number], input[type=email], input[type=password], select',
    function (event) {
      $(this).parent().addClass('focus')
    }
  ).on('focusout', 'textarea.focus',
    function (event) {
      $(this).removeClass('focus')
    }
  ).on('click', '[data-destroy]',
    function (event) {
      var container = $(this).data('destroy');
      if (container) {
        $('.' + container).remove();
      }
    }
  ).on('click', '[data-redirect]',
    function (event) {
      var redirect = $(this).data('redirect');
      if (redirect) {
        window.location.href = redirect;
      }
    }
  ).on('focus', 'textarea',
    function (event) {
      $(this).addClass('focus')
    }
  ).on('focusout', '.focus input , textarea.focus',
    function (event) {
      $(this).parent().removeClass('focus')
    }
  ).ready(function () {

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
        if (url && (!$('textarea, input').is(':focus'))) {
          $('body').waitloader('show');
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

    $("a[data-rel^='prettyPhoto']").prettyPhoto({
      hook: "data-rel",
      social_tools: '',
      theme: "pp_woocommerce",
      //	horizontal_padding: 20,
      //	opacity: .8,
      //	show_title: false,
      //  allow_resize: false,
      default_width: 700
    });

    $.change_button_text();
    $('[title]').tooltipster();

    body.waitloader('remove');

  });

})(window.jQuery || window.$);
