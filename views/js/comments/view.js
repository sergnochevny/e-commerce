(function ($) {

  $('#modal-title').html($('.modal-view').attr('data-title'));
  $('#modal').modal('show').find('.modal-footer').stop().hide();

})(jQuery);