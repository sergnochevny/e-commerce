'use strict';
(function ($) {
  var base_url = $('#base_url').val();

  $(document).off('.basket');

  $(document).on('click', '.shop__sidebar-list a[data-index]',
    function (event) {
      $('.shop__sidebar-list .active').removeClass('active');
      $(this).addClass('active');
    }
  );

  $(document).on('click.basket', '#to_basket',
    function (event) {
      event.preventDefault();

      var url = $(this).attr('href'),
        container = $(this).parent('figcaption');

      $('#content').waitloader('show');

      $.get(url, {}, function (answer) {
          var data = JSON.parse(answer);
          $.when(
            $('span#cart_amount').html(data.sum),
            $(data.msg).appendTo('#content')
          ).done(function () {
              if (data.button) {
                $(container).html(data.button)
              }

              $('#content').waitloader('remove');

              var buttons = {
                "Cart": function () {
                  $(this).remove();
                  $('#content').waitloader('show');
                  window.location = base_url + 'cart';
                }
              };

              $('#modal').dialog({
                draggable: false,
                dialogClass: 'msg',
                title: 'Add to Cart',
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

            }
          );
        }
      );
    }
  );

  $(document).on('click', '[data-product]',
    function(event){
      event.preventDefault();
      if($(this).find(' > a').length){
        $('body').waitloader('show');
        location.href = $(this).find(' > a').attr('href');
      }
    }
  );

  $(document).on('click', '[data-product] > a', function(event){event.stopPropagation();});

})(jQuery);