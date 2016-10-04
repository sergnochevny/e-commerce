'use strict';

(function ($) {

    var throwPopupConfirm = function () {
            $("#confirm-dialog").addClass('overlay_display');
        },
        hidePopupConfirm = function () {
            $("#confirm-dialog").removeClass('overlay_display');
            $('.popup .confirm, .colour-update').off()
        },
        loadForm = function () {
            $('#modal_content').html('\
                <form id="color-au-form"> \
                    <div class="form-row">\
                        <label for="colour-name">Color name</label>\
                        <input type="text" class="input-text" name="colour-name" id="colour-name-input">\
                    </div>\
                </form>');
            $('#modal').modal('show');
        },
        ajaxSend = function (method, url, data, callback) {
            var this_ = this;
            $(document.body).waitloader('show');
            $.ajax({
                type: method,
                url: url,
                data: data,
                success: function (data) {
                    $(document.body).waitloader('remove');
                },
                error: function (xhr, str) {
                    $(document.body).waitloader('remove');
                    alert('Error: ' + xhr.responseCode);
                },
                complete: function () {
                    callback.call(this_);
                }
            })
        };

    $('#modal').on('hidden.bs.modal', function () {
        $(this).find('#modal_content').empty();
        $('.save-data, .colour-update').off();
    });

    $('.popup.close, .popup .dismiss').on('click', hidePopupConfirm);

    $(document).on('click', '.colour-create', function (e) {
        e.preventDefault();
        var createUrl = $(this).data('href');
        loadForm();
        $('#modal .save-data').on('click',
            function () {
                var color = $('#colour-name-input').val();
                ajaxSend.call(this,
                    'POST',
                    createUrl,
                    {
                        colour_name: color
                    },
                    function () {
                        $(this).off()
                    }
                );
            }
        )
    });

    $(document).on('click', '.colour-update', function (e) {
        e.preventDefault();
        var updateUrl = $(this).data('href'),
            id = $(this).data('id'),
            name = $('.colour-name-container[data-group=' + id + '] span.c-name').text();

        loadForm();
        $('#colour-name-input').val(name);

        $('#modal .save-data').on('click', function () {
            var val = $('#colour-name-input').val();
            ajaxSend.call(this,
                'GET',
                updateUrl, {
                    id: id,
                    colour_name: val
                },
                function () {
                    $(this).off();
                    $('.colour-name-container[data-group=' + id + ']').children('span.c-name').text(val)
                }
            );
        });
    });

    $(document).on('click', '.colour-delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            href = $(this).data('href'),
            toDeleteLineObj = $(this).parent('td').parent('tr');

        $('.popup .confirm').on('click',
            function () {
                ajaxSend.call(this,
                    'POST',
                    href, {
                        id: id
                    },
                    function () {
                        $(this).off();
                        hidePopupConfirm();
                    }
                );
                toDeleteLineObj.remove();
            }
        );

        throwPopupConfirm();
    });


})(jQuery);