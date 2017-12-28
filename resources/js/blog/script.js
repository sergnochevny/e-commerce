(function ($) {
  'use srtict';

  $("input").inputmask();

  $.danger_remove(8000);

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


  $('#modal').on('hidden.bs.modal',
    function () {
      $(this).find('#modal_content').empty();
    }
  );

  function evRemoveFilterRow(event) {
    $(this).parents('li.selected_item').remove();
  }

  function setEvToFilter() {
    $('span[data-rem_row]').on('click',
      function (event) {
        evRemoveFilterRow.call(this, event);
      }
    );

    $('form#edit_form a[name=edit_filter]').on('click',
      function (event) {
        event.preventDefault();
        evFilterAdd.call(this, event);
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
          $.when(
            $(destination).html(data[0]),
            $('#modal_content').html(data[1])
          ).done(
            function () {
              setEvToFilter();
              setEvToFilterSearch();
            }
          );
        } catch (e) {
          $(destination).html(data);
        }
      }
    );
  }

  function setEvToFilterSearch() {

    $('[data-filter-search]').on('click',
      function (event) {
        event.preventDefault();
        evFilterSearch.call(this, event);
      }
    );

    $('li.select_item input').on('change',
      function (event) {
        if (!this.checked) {
          $('span[data-rem_row][data-index=' + $(this).val() + ']').trigger('click');
        }
      }
    );
  }

  function evFilterAdd(event) {
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
        setEvToFilterSearch();
        $('#modal').modal('show');
      }
    );
  }

  $("#save").on('click', function (event) {
    event.preventDefault();
    $('#edit_form').trigger('submit', [true]);
  });

  setEvToFilter();

  $('form#edit_form').init_input();

})(window.jQuery || window.$);
