'use strict';
(function ($) {

  var danger = $('.danger');

  if (danger.length) {
    danger.css('display', 'block');
    $('html, body').stop().animate({scrollTop: parseInt(danger.offset().top) - 250}, 1000);
    setTimeout(function () {
      $('.danger').css('display', 'none');
    }, 8000);
  }

  setEvToFilter();

  function postdata(this_, url, data, context, callback) {
    $('body').waitloader('show');
    $.ajax({
      type: 'POST',
      url: url,
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: function (data) {
        if (context !== undefined && context !== null) {
          $.when(context.html(data)).done(
            function () {
              if (callback) callback.call(this_, data);
              $('body').waitloader('remove');
            }
          );
        } else {
          if (callback) callback.call(this_, data);
          $('body').waitloader('remove');
        }
      },
      error: function (xhr, str) {
        alert('Error: ' + xhr.responseCode);
        $('body').waitloader('remove');
      },
    });
  }

  $('form#edit_form').on('submit',
    function (event, submit) {
      event.preventDefault();
      if (submit) {
        var data = new FormData(this);
        var url = $(this).attr('action');
        postdata(this, url, data, $('#form_content'));
      }
    }
  );

  // $(document).on('submit', '#blog_post',
  //   function (event) {
  //     event.preventDefault();
  //     $('[name=title]').val(tinyMCE.get('editable_title').getContent());
  //     $('[name=content]').val(tinyMCE.get('editable_content').getContent());
  //     var msg = $(this).serialize(),
  //       url = $(this).attr('action');
  //     $.ajax({
  //       type: 'POST',
  //       url: url,
  //       data: msg,
  //       success: function (data) {
  //         $.when(
  //           $('#alert').html(data)
  //         ).done(
  //           function () {
  //             var danger = $('.danger');
  //             $(document).trigger('tiny_init');
  //             if (danger.length) {
  //               danger.css('display', 'block');
  //               $('html, body').stop().animate({
  //                 scrollTop: parseInt(danger.offset().top) - 250
  //               }, 1000);
  //               setTimeout(function () {
  //                 $('.danger').remove();
  //               }, 8000);
  //             }
  //           }
  //         );
  //
  //       },
  //       error: function (xhr, str) {
  //         alert('Error: ' + xhr.responseCode);
  //       }
  //     });
  //   }
  // );


  $('#build_filter').on('click',
    function () {
      var destination = $('[data-filter=' + $(this).attr('data-destination') + ']').parent('div');
      var data = new FormData($('form#edit_form')[0]);
      var url = $('form#edit_form').attr('action');
      for(var pair of (new FormData($('form#categories')[0])).entries()){
        data.append(pair[0],pair[1]);
      }
      data.append('method', $(this).attr('href'));
      data.append('type', $(this).attr('data-destination'));
      postdata(this, url, data, destination,
        function () {
          $('#modal').modal('hide');
          setEvToFilter();
        }
      );
    }
  );

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

  function evFilterAdd(event) {
    debugger;
    var data = new FormData($('form#edit_form')[0]);
    var url = $('form#edit_form').attr('action');
    data.append('method', $(this).attr('href'));
    var destination = $(this).attr('data-destination');
    var title = $(this).attr('data-title');
    postdata(this, url, data, $('#modal_content'),
      function () {
        $('#modal-title').html(title);
        $('#build_filter').attr('data-destination', destination);
        $('a[data-filter-search]').attr('data-destination', destination);
        setEvToFilterSearch();
        $('#modal').modal('show');
      }
    );
  }

  function setEvToFilterSearch() {

    $('a[data-filter-search]').on('click',
      function (event) {
        event.preventDefault();
        evFilterSearch.call(this, event);
      }
    );

    $('input[data-input_filter_search]').on('change',
      function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parents('.row').find('[data-filter-search]').trigger('click');
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

  function evFilterSearch() {
    debugger;
    var data_destination = $(this).attr('data-destination');
    var destination = $('[data-filter=' + data_destination + ']').parent('div');
    var data = new FormData($('form#edit_form')[0]);
    for(var pair of (new FormData($('form#categories')[0])).entries()){
      data.append(pair[0],pair[1]);
    }
    var url = $('form#edit_form').attr('action');
    if ($(this).is('[data-move]')) data.append($(this).attr('data-move'), true);
    data.append('method', $(this).attr('href'));
    data.append('type', data_destination);
    data.append('filter-type', $(this).attr('data-filter-type'));
    postdata(this, url, data, null,
      function (response) {
      debugger;
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
      }
    );
  }

  $("#save").on('click', function (event) {
    debugger;
    event.preventDefault();
    $('#edit_form').trigger('submit');
  });

  $("#close").on('click', function (event) {
    // $('[data-id=blog_post_form_dialog]').each(function () { $(this).hide(); });
  });

})(jQuery);