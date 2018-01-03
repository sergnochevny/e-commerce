(function ($) {
  'use strict';

  $(document).on('submit', "form#edit_form",
    function (event) {
      event.preventDefault();
      var url = $(this).attr('action');
      var data = new FormData(this);
      var container = $(this).parents('[data-role=form_content]');
      if (container.length == 0) container = $(this).parent();
      $('body').waitloader('show');
      $.postdata(this, url, data, function (data) {
        container.html(data);
        $('body').waitloader('remove');
      });
    }
  ).on('click', 'form input[data-role=submit]',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
    }
  );

})(window.jQuery || window.$);