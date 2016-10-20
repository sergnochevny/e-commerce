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
      $(document).on('mouseenter', 'input[name=uploadfile]', function (event) {
        $('#post_img').css('border', 'dotted');
      }).on('mouseleave', 'input[name=uploadfile]', function (event) {
        $('#post_img').css('border', '');
      });
    }
  );
  $(document).on('click', '#pre_save',
    function (event) {
      event.preventDefault();
      $('#dialog').dialog({
        modal: true,
      });
      $('html, body').stop().animate({scrollTop: parseInt($('#dialog').offset().top) - 100}, 1000);
    }
  );

})(jQuery);