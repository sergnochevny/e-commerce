'use strict';

(function ($) {

  $(document).on('tiny_init',
    function (event) {
      tinymce.init(
        {
          selector: '#editable_content',
          images_upload_base_path: '/img/blog',
          plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks fullscreen",
            "code",
            "insertdatetime table contextmenu paste imagetools textcolor responsivefilemanager"
          ],
          toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
          toolbar2: "| responsivefilemanager  image | link unlink anchor | forecolor backcolor  | print preview code ",
          image_advtab: true,
          external_filemanager_path: "<?= _A_::$app->router()->UrlTo('filemanager/') ?>",
          relative_urls: false,
          remove_script_host: false,
          inline: true
        }
      );

      tinymce.init(
        {
          selector: '#editable_title',
          menubar: false,
          toolbar: false,
          inline: true
        }
      );
    }
  );
  $(document).ready(
    function () {
      $(document).trigger('tiny_init');
      $(document).on('mouseenter', '#post_img', function (event) {
        $('#post_img').css('border', 'dotted');
      }).on('mouseleave', '#post_img', function (event) {
        $('#post_img').css('border', '');
      });
    }
  );

  $(document).on('click', 'a#pre_save',
    function (event) {
      event.preventDefault();
      $('#dialog').removeClass('hidden');
      $('.blog-post-edit-in').addClass('hidden');
      $('html, body').stop().animate({scrollTop: parseInt($('#dialog').offset().top) - 100}, 100);
    }
  );
  $(document).on('click', 'a#cancel',
    function (event) {
      event.preventDefault();
      $('.blog-post-edit-in').removeClass('hidden');
      $('#dialog').addClass('hidden');
      $('html, body').stop().animate({scrollTop: parseInt($('.blog-post-edit-in').offset().top) - 100}, 100);
    }
  );
})(jQuery);