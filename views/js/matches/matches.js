'use strict';

(function ($) {

  var a = 1,
    base_url = $('#base_url').val();

  $(document).ready(function (event) {
    setTimeout(function () {
      $('html,body').stop().animate({
        scrollTop: $('#content').offset().top
      }, 2000);
    }, 300);
  });

  $('#dragZoneArea > img').mousedown(function (eventObject) {
    $(this).css("z-index", a++);
  }).draggable({
    containment: "#dragZoneArea",
    start: function (event, ui) {
      $(this).css("z-index", a++);
    }
  });

  $(document).on('dblclick', "img#product_img_holder", function (event) {
    var url = $(this).attr('data-detail_url');
    window.location = url;
  });

  $('.deleteDragImg').droppable({
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {
      var url = $(ui.draggable).attr('data-delete_url');
      $('#content').waitloader('show');
      var data = new FormData();
      $.postdata(this, url, data,
        function (data) {
          $(ui.draggable).remove();
          $('#content').waitloader('remove');
        }
      )
    }
  });

  $('.detailsDragImg').droppable({
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {
      $('#content').waitloader('show');
      var url = $(ui.draggable).attr('data-detail_url');
      window.location = url;
    }
  });

  $('#clear_matches').on('click', function (ev) {
    ev.preventDefault();
    var url = $(this).attr('href');
    $('#content').waitloader('show');
    var data = new FormData();
    $.postdata(this, url, data, function (data) {
      $('img#product_img_holder').each(function () {
        $(this).remove();
      });
      $('#content').waitloader('remove');
    });
  });

  $('#all_to_basket').on('click',
    function (ev) {
      ev.preventDefault();
      var products = [];
      $('#dragZoneArea').children('img').each(function (idx, element) {
        products.push($(this).attr('data-id'));
      });

      products = JSON.stringify(products);
      var url = $(this).attr('href');
      var load_url = base_url + 'cart/amount';
      var data = new FormData();
      data.append('data', products);
      $('#content').waitloader('show');

      $.postdata(this, url, data, function (data) {
        $.when(
          $('#content').waitloader('remove'),
          $(data).appendTo('#content'),
          $('span#cart_amount').load(load_url)
        ).done(function () {
//                          if($('span#cart_amount').length>0){
          $('#clear_matches').trigger('click');
          var buttons = {
            "Cart": function () {
              $(this).remove();
              $('#content').waitloader('show');
              window.location = base_url + 'cart';
            }
          };
          $('#msg').dialog({
            draggable: false,
            dialogClass: 'msg',
            title: 'Add All to Cart',
            modal: true,
            zIndex: 10000,
            autoOpen: true,
            width: '700',
            resizable: false,
            buttons: buttons,
            close: function (event, ui) {
              $(this).remove();
            }
          });
          $('.msg').css('z-index', '10001');
          $('.ui-widget-overlay').css('z-index', '10000');
//                          }
        });

      });
    });

})(jQuery);