'use strict';
(function ($) {

    function postdata(url, data) {
        $('body').waitloader('show');
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                $.when(
                    $('#content').html(data)
                ).done(function () {
                    $('body').waitloader('remove');
                });
            },
            error: function (xhr, str) {
                alert('Error: ' + xhr.responseCode);
                $('body').waitloader('remove');
            }
        });
    }

    $(document).on('submit.search_action', "form[data-search]", function (event, reset) {
        event.preventDefault();
        if (reset) {
            data = {empty:true};
        } else {

            var data = new FormData(this),
                search = $('form[data-sort]');

            if (search.length) {
                (new FormData(search[0])).forEach(function (value, key) {
                    data.append(key, value);
                });
            }
        }
        postdata.call(this, $(this).attr('action'), data);
    });

    $(document).on('click.search_action', "form[data-search] [data-search_reset]", function (event) {
        event.preventDefault();
        event.stopPropagation();
        var search = $('form[data-search]');
        search.trigger('submit', true);
    });

    $(document).on('click.search_action', "form[data-search] [data-search_submit]", function () {
        var search = $('form[data-search]');
        search.trigger('submit');
    });

    $(document).on('click.search_action', "[data-to_page]", function (event) {
        event.preventDefault();
        var search = $('form[data-search]');
        if (search.length) {
            search.attr('action', $(this).attr('href')).trigger('submit');
        } else {
            var data = {empty:true};
            if (search.length) {
                data = new FormData(search[0]);
            }
            postdata($(this).attr('href'), data);
        }
    });

    $(document).on('click.search_action', "[data-sort]", function (event) {
        event.preventDefault();
        var search = $('form[data-search]');
        if (search.length) {
            search.attr('action', $(this).attr('href')).trigger('submit');
        } else {
            postdata($(this).attr('href'), {empty: true});
        }
    });

})(jQuery);