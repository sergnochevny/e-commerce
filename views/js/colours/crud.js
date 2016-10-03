'use strict';

(function ($) {

    var throwPopupConfirm = function () {
            $("#confirm-dialog").addClass('overlay_display');
        },
        hidePopupConfirm = function () {
            $("#confirm-dialog").removeClass('overlay_display');
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
        ajaxSend = function (method, url, data) {
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
                }
            })
        };

    $('#modal').on('hidden.bs.modal', function () { $(this).find('#modal_content').empty(); });

    $('.popup').on('click', '.close, .dismiss', hidePopupConfirm);

    $(document.body).off('click').on('click', '.colour-create', function (e) {
        e.preventDefault();
        var createUrl = $(this).data('href');
        loadForm();
        $('#modal').on('click', '.save-data', function () {
            var color = $('#colour-name-input').val();
            ajaxSend('POST', createUrl, {colour_name: color});
        })
    });

    $(document.body).off('click').on('click', '.colour-delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            href = $(this).data('href'),
            toDeleteLineObj = $(this).parent('td').parent('tr');

        $('.popup').off('click').on('click', '.confirm', function () {
            ajaxSend('POST', href, {id: id});
            hidePopupConfirm();
            toDeleteLineObj.remove();
        });

        throwPopupConfirm();
    });


})(jQuery);