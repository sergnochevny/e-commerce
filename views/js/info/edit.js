'use strict';
(function ($) {

  $(document).on('click', '#submit',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', true);
    }
  );

  $(document).on('submit', "#edit_form",
    function (event, submit) {
      event.preventDefault();
      if (submit) {
        $('[name=message]').html(tinyMCE.get('editable_content').getContent());
        var data = new FormData(this);
        var url = $(this).attr('action');
        $.postdata(this, url, data, function (data) {
          tinyMCE.get('editable_content').remove();
          $('#form_content').html(data)
        });
      }
    }
  );

  $(document).on('tiny_init',
    function (event) {
      tinymce.init(
        {
          selector: '#editable_content',
          plugins: [
            "advlist autolink lists preview",
            "searchreplace visualblocks fullscreen",
            "code link",
            "insertdatetime contextmenu paste textcolor"
          ],
          toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink | forecolor | preview ",
          remove_script_host: false,
        }
      );
    }
  );

})(jQuery);