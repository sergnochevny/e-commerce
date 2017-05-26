'use strict';

(function ($) {
  var filemanager_url = $('[data-filemanager]').attr('data-filemanager');
  $(document).on('tiny_init',
    function (event) {
      tinymce.init(
        {
          selector: '#editable_content',
          images_upload_base_path: '/img/blog',
          plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks fullscreen',
            'code link',
            'insertdatetime table contextmenu paste imagetools textcolor responsivefilemanager',
          ],
          toolbar1: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect',
          toolbar2: '| responsivefilemanager  image | link unlink anchor | forecolor backcolor  | print preview code ',
          image_advtab: true,
          external_filemanager_path: filemanager_url,
          relative_urls: false,
          remove_script_host: false,
          inline: true,
        }
      );

      tinymce.init(
        {
          selector: '#editable_title',
          menubar: false,
          toolbar: false,
          inline: true,
        }
      );
    }
  );

  $(document).on('click', '#pre_save',
    function (event) {
      event.preventDefault();
      $('#dialog').removeClass('hidden');
      $('.blog-post-edit-in').addClass('hidden');
      $('html, body').stop().animate({scrollTop: parseInt($('#dialog').offset().top, 10) - 100}, 100);
    }
  );
  $(document).on('click', '#cancel',
    function (event) {
      event.preventDefault();
      $('.blog-post-edit-in').removeClass('hidden');
      $('#dialog').addClass('hidden');
      $('html, body').stop().animate({scrollTop: parseInt($('.blog-post-edit-in').offset().top, 10) - 100}, 100);
    }
  );

  $(document).trigger('tiny_init');
})(jQuery);
