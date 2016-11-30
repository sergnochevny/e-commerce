(function ($) {

  $("input").inputmask();

  $.danger_remove(8000);

  function postdata(this_, url, data, context, callback) {
    $('body').waitloader('show');
    $.postdata(this_, url, data, function (data) {
      if (context !== undefined && context !== null) {
        $.when(context.html(data)).done(
          function () {
            if (callback) callback.call(this_, data);
            $('body').waitloader('remove');
          }
        );
      } else {
        if (callback) callback.call(this_, data);
        $('body').waitloader('remove');
      }
    });
  }

  $('form#edit_form').on('submit',
    function (event, submit) {
      event.preventDefault();
      if (submit) {
        var data = new FormData(this);
        var url = $(this).attr('action');
        var container = $(this).parents('[data-role=form_content]');
        if (container.length == 0) container = $(this).parent();
        postdata(this, url, data, container);
      }
    }
  );

  $('#submit').on('click',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
    }
  );

  function LoadContent() {
    $('body').waitloader('show');
    var products = $('[data-edit_products]');
    var url = $('[data-products_get_list]').val();
    products.load(url, function () {
      $('body').stop().animate({scrollTop: 0});
      $('body').waitloader('remove');
    });
  }

  LoadContent();

})(jQuery);