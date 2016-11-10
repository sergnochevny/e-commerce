'use strict';
(function ($) {
  var danger = $('.danger');
  if (danger.length) {
    danger.css('display', 'block');

    setTimeout(function () {
      danger.css('display', 'none');
    }, 8000);
  }

  $("#edit_form").on('submit', function (event) {
    event.preventDefault();
    var url = $(this).attr('action');
    var data = new FormData(this);

    $('body').waitloader('show');
    $.postdata(this, url, data, function (data) {
      $('#form_content').html(data);
    });
  });
})(jQuery);