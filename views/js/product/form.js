(function ($) {

  $("input").inputmask();

  $.danger_remove(8000);

  if ($('[data-related] .product-item').length) {
    $('[data-carousel]').owlCarousel(
      {
        responsive: {0: {items: 1}, 520: {items: 2}, 820: {items: 3}, 990: {items: 4}},
        margin: 15,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        autoplay: true,
        loop: false,
        rewind: true,
        autoplayHoverPause: true,
        dots: true
      }
    );
  }

  setEvToFilter();

  function postdata(this_, url, data, context, callback) {
    $('body').waitloader('show');
    $.postdata(this_, url, data, function (data) {
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
    });
  }

  $('form#edit_form').on('submit',
    function (event, submit) {
      event.preventDefault();
      if (submit) {
        var data = new FormData(this);
        var url = $(this).attr('action');
        var container = $(this).parents('[data-role=form_content]');
        if (container.length == 0) container = $(this).parent();
        postdata(this, url, data, container);
      }
    }
  );

  $('#build_filter').on('click',
    function () {
      var destination = $('[data-filter=' + $(this).attr('data-destination') + ']').parent('div');
      var data = new FormData($('form#edit_form')[0]);
      var url = $('form#edit_form').attr('action');
      data.append('method', $(this).attr('href'));
      data.append('type', $(this).attr('data-destination'));
      postdata(this, url, data, destination,
        function (data) {
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

  $('#submit').on('click',
    function (event) {
      event.preventDefault();
      $(this).parents('form').trigger('submit', [true]);
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
    var data = new FormData($('form#edit_form')[0]);
    var url = $('form#edit_form').attr('action');
    data.append('method', $(this).attr('href'));
    var destination = $(this).attr('data-destination');
    var title = $(this).attr('data-title');
    postdata(this, url, data, $('#modal_content'),
      function () {
        $('#modal-title').html(title);
        $('#build_filter').attr('data-destination', destination);
        $('[data-filter-search]').attr('data-destination', destination);
        setEvToFilterSearch();
        $('#modal').modal('show');
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

  $('.popup a.close').on('click.confirm_action', function (event) {
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
  });

  $('#confirm_no').on('click.confirm_action', function (event) {
    $(".popup a.close").trigger('click');
  });

  $('[data-delete]').on('click', function (event) {
    event.preventDefault();
    if (!$(this).is('.disabled')) {
      var href = $(this).attr('href');
      $("#confirm_action").on('click.confirm_action', function (event) {
        $('body').waitloader('show');
        event.preventDefault();
        $("#confirm_dialog").removeClass('overlay_display');
        $('#content').load(href);
        $("#confirm_action").off('click.confirm_action');
        $('body').waitloader('remove');
      });
      $("#confirm_dialog").addClass('overlay_display');
    }
  });

  $.init_input();

})(jQuery);