(function ($) {
  'use srtict';

  var filemanager_url = $('[data-filemanager]').attr('data-filemanager');
 
  $(document).on('tiny_init',
    function (event) {
      tinymce.init(
        {
          selector: '#editable_content',
          images_upload_base_path: '/images/blog',
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

  function postdata(this_, url, data, context, callback) {
    $.postdata(this_, url, data,
      function (data) {
        if (context !== undefined && context !== null) {
          $.when($(context[0]).html(data)).done(
            function () {
              if (callback) callback.call(this_, data);
            }
          );
        } else {
          if (callback) callback.call(this_, data);
        }
      }
    );
  }

  function evFilterSearch() {
    var data_destination = $(this).attr('data-destination');
    var destination = $('[data-filter=' + data_destination + ']').parent('div');
    var data = new FormData($('form#edit_form')[0]);
    var url = $('form#edit_form').attr('action');
    if ($(this).is('[data-move]')) data.append($(this).attr('data-move'), true);
    data.append('method', $(this).attr('href'));
    data.append('type', data_destination);
    data.append('filter-type', $(this).attr('data-filter-type'));
    postdata(this, url, data, null,
      function (response) {
        try {
          var data = JSON.parse(response);
          $(destination).html(data[0]);
          $('#modal_content').html(data[1])
        } catch (e) {
          $(destination).html(data);
        }
      }
    );
  }

  function evFilterAdd() {
    var data = new FormData($('form#edit_form')[0]);
    var url = $('form#edit_form').attr('action');
    data.append('method', $(this).attr('href'));
    var destination = $(this).attr('data-destination');
    var title = $(this).attr('data-title');
    postdata(this, url, data, $('#modal_content'),
      function () {
        $('#modal_content').init_input();
        $('#modal-title').html(title);
        $('#modal-title').init_input();
        $('#build_filter').attr('data-destination', destination);
        $('[data-filter-search]').attr('data-destination', destination);
        $('#modal').modal('show');
      }
    );
  }

  function evRemoveFilterRow() {
    $(this).parents('li.selected_item').remove();
  }

  $(document).on('hidden.bs.modal', '#modal',
    function () {
      $(this).find('#modal_content').empty();
    }
  );

  $(document).on('click', 'span[data-rem_row]',
    function (event) {
      event.preventDefault();
      evRemoveFilterRow.call(this);
    }
  );

  $(document).on('click', 'form#edit_form a[name=edit_filter]',
    function (event) {
      event.preventDefault();
      evFilterAdd.call(this);
    }
  );

  $(document).on('click', '#pre_save',
    function (event) {
      var el = $('#dialog');
      event.preventDefault();
      el.removeClass('hidden');
      $('.blog-post-edit-in').addClass('hidden');
      $('html, body').stop().animate({scrollTop: parseInt(el.offset().top, 10) - 100}, 100);
    }
  );

  $(document).on('click', "#save", function (event) {
    event.preventDefault();
    $('#edit_form').trigger('submit', [true]);
  });

  $(document).on('click', '#cancel',
    function (event) {
      var el = $('.blog-post-edit-in');
      event.preventDefault();
      el.removeClass('hidden');
      $('#dialog').addClass('hidden');
      $('html, body').stop().animate({scrollTop: parseInt(el.offset().top, 10) - 100}, 100);
    }
  );

  $(document).on('click', '[data-filter-search]',
    function (event) {
      event.preventDefault();
      evFilterSearch.call(this, event);
    }
  );

  $(document).on('change', 'li.select_item input',
    function (event) {
      event.preventDefault();
      if (!this.checked) {
        $('span[data-rem_row][data-index=' + $(this).val() + ']').trigger('click');
      }
    }
  );

  $(document).on('submit', 'form#edit_form',
    function (event, submit) {
      event.preventDefault();
      if (submit) {
        $('[name=post_title]').val(tinyMCE.get('editable_title').getContent());
        $('[name=post_content]').val(tinyMCE.get('editable_content').getContent());
        var data = new FormData(this);
        var url = $(this).attr('action');
        var container = $(this).parents('[data-role=form_content]');
        if (container.length === 0) container = $(this).parent();
        postdata(this, url, data, container, function (data) {
          $(document).trigger('tiny_init');
        });
      }
    }
  );

  $(document).on('click', '#build_filter',
    function () {
      var destination = $('[data-filter=' + $(this).attr('data-destination') + ']').parent('div');
      var data = new FormData($('form#edit_form')[0]);
      var url = $('form#edit_form').attr('action');
      data.append('method', $(this).attr('href'));
      data.append('type', $(this).attr('data-destination'));
      postdata(this, url, data, destination,
        function () {
          $(destination).init_input();
          $('#modal').modal('hide');
        }
      );
    }
  );

  $(document).trigger('tiny_init');
})(window.jQuery || window.$);
