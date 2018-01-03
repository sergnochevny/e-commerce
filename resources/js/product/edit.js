(function ($) {

  function postdata(this_, url, data, context, callback) {
    $.postdata(this_, url, data, function (data) {
      if (context !== undefined && context !== null) {
        $.when($(context[0]).html(data)).done(
          function () {
            if (callback) callback.call(this_, data);
          }
        );
      } else {
        if (callback) callback.call(this_, data);
      }
    });
  }

  function evRemoveFilterRow() {
    $(this).parents('li.selected_item').remove();
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

  $(document).on('submit', 'form#edit_form',
    function (event, submit) {
      event.preventDefault();
      if (submit) {
        var data = new FormData(this);
        var url = $(this).attr('action');
        var container = $(this).parents('[data-role=form_content]');
        if (container.length === 0) container = $(this).parent();
        postdata(this, url, data, container);
      }
    }
  ).on('click', '#build_filter',
    function () {
      var destination = $('[data-filter=' + $(this).attr('data-destination') + ']').parent('div');
      var data = new FormData($('form#edit_form')[0]);
      var url = $('form#edit_form').attr('action');
      data.append('method', $(this).attr('href'));
      data.append('type', $(this).attr('data-destination'));
      postdata(this, url, data, destination,
        function (data) {
          $(destination).init_input();
          $('#modal').modal('hide');
        }
      );
    }
  ).on('hidden.bs.modal', '#modal',
    function () {
      $(this).find('#modal_content').empty();
    }
  ).on('click', '#submit',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
    }
  ).on('click', 'span[data-rem_row]',
    function (event) {
      evRemoveFilterRow.call(this, event);
    }
  ).on('click', 'form#edit_form a[name=edit_filter]',
    function (event) {
      event.preventDefault();
      evFilterAdd.call(this, event);
    }
  ).on('click', '[data-filter-search]',
    function (event) {
      event.preventDefault();
      evFilterSearch.call(this, event);
    }
  ).on('change', 'li.select_item input',
    function (event) {
      event.preventDefault();
      if (!this.checked) {
        $('span[data-rem_row][data-index=' + $(this).val() + ']').trigger('click');
      }
    }
  ).on('click.confirm_action', '.popup a.close', function (event) {
    event.preventDefault();
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
  }).on('click.confirm_action', '#confirm_no', function (event) {
    event.preventDefault();
    $(".popup a.close").trigger('click');
  }).on('click', '[data-delete]', function (event) {
    event.preventDefault();
    if (!$(this).is('.disabled')) {
      var href = $(this).attr('href');
      $("#confirm_action").on('click.confirm_action', function (event) {
        $('body').waitloader('show');
        event.preventDefault();
        $("#confirm_dialog").removeClass('overlay_display');
        $('#content').load(href).done(function () {
          $('body').waitloader('remove');
        });
        $("#confirm_action").off('click.confirm_action');
      });
      $("#confirm_dialog").addClass('overlay_display');
    }
  });

})(window.jQuery || window.$);