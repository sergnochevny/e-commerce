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
    },
    revert: function (dropped) {
      return (dropped && $(dropped).hasClass('AddToCartDragImg'));
    }
  });

  $(document).on('dblclick', "img.product_img_holder", function (event) {
    $('body').waitloader('show');
    window.location = $(this).attr('data-detail_url');
  });

  $('.deleteDragImg').droppable({
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {
      var url = $(ui.draggable).attr('data-delete_url');
      var data = new FormData();

      $('body').waitloader('show');
      $.postdata(this, url, data,
        function (data) {
          $(ui.draggable).remove();
          $('body').waitloader('remove');
        }
      )
    }
  });

  $('.detailsDragImg').droppable({
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {
      $('body').waitloader('show');
      window.location = $(ui.draggable).attr('data-detail_url');
    }
  });

  $('.AddToCartDragImg').on('click', function () {
    $('body').waitloader('show');
    window.location = base_url + 'cart';
  });

  $('.AddToCartDragImg').droppable({
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {
      var products = [];
      var $this = this;
      var url = $($this).attr('data-href');
      var load_url = base_url + 'cart/amount';
      var data = new FormData();

      products.push($(ui.draggable).attr('data-id'));
      products = JSON.stringify(products);
      data.append('data', products);
      $('body').waitloader('show');

      $.postdata(this, url, data, function (data) {
        $.when(
          $('body').waitloader('show'),
          $(data).appendTo('#content'),
          $('span#cart_amount').load(load_url).done(function(){
            $('body').waitloader('remove');
          })
        ).done(function () {
          $($this).removeClass('simple-icon-basket').addClass('simple-icon-basket-loaded');
          $('#modal').modal('show').on('hidden.bs.modal', function () {
            $(this).remove();
          });
        });
      });
    }
  });

  $('#clear_matches').on('click', function (ev) {
    var url = $(this).attr('href');
    var data = new FormData();

    ev.preventDefault();
    $('body').waitloader('show');
    $.postdata(this, url, data, function (data) {
      $('img.product_img_holder').each(function () {
        $(this).remove();
      });
      $('body').waitloader('remove');
    });
  });

  $('#all_to_basket').on('click', function (ev) {
    var products = [];
    var url = $(this).attr('href');
    var load_url = base_url + 'cart/amount';
    var data = new FormData();

    $('#dragZoneArea').children('img').each(function (idx, element) {
      products.push($(this).attr('data-id'));
    });

    ev.preventDefault();
    products = JSON.stringify(products);
    data.append('data', products);
    $('body').waitloader('show');

    $.postdata(this, url, data, function (data) {
      $('body').waitloader('show');
      $.when(
        $(data).appendTo('#content'),
        $('span#cart_amount').load(load_url).done(function(){
          $('body').waitloader('remove');
        })
      ).done(function () {
        $('#clear_matches').trigger('click');
        $('#modal').modal('show').on('hidden.bs.modal', function () {
          $(this).remove();
        });
      });
    });
  });

})(jQuery);