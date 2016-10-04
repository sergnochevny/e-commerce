'use strict';

(function ($) {

    var throwPopupConfirm = function () {
            $("#confirm-dialog").addClass('overlay_display');
        },

        hidePopupConfirm = function () {
            $("#confirm-dialog").removeClass('overlay_display');
            $('.popup .confirm, .manufacturers-update').off()
        },

        loadForm = function () {
            $('#modal_content').html('\
                <form id="color-au-form"> \
                    <div class="form-row">\
                        <label for="manufacturers-name">Color name</label>\
                        <input type="text" class="input-text" name="manufacturers-name" id="manufacturers-name-input">\
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
        },

        throwNotification = function (notificationContent, notificationType, notificationVisibilityTime) {
            $('.notification').text(notificationContent).addClass(notificationType).removeClass('hidden');
            setTimeout(function(){
                $('.notification').text('').removeClass(notificationType).addClass('hidden')
            }, notificationVisibilityTime);
        };

    $('#modal').on('hidden.bs.modal', function () {
        $(this).find('#modal_content').empty();
        $('.save-data, .manufacturers-update').off();
    });

    $('.popup.close, .popup .dismiss').on('click', hidePopupConfirm);

    $(document).on('click', '.manufacturers-create', function (e) {
        e.preventDefault();
        var createUrl = $(this).data('href');
        loadForm();
        $('#modal .save-data').on('click',
            function () {
                var color = $('#manufacturers-name-input').val();
                ajaxSend.call(this,
                    'POST',
                    createUrl,
                    {
                        manufacturers_name: color
                    },
                    function () {
                        throwNotification('Color ' + color + ' was added successfully.', 'alert-success', 6000);
                        $(this).off()
                    }
                );
            }
        )
    });

    $(document).on('click', '.manufacturers-update', function (e) {
        e.preventDefault();
        var updateUrl = $(this).data('href'),
            id = $(this).data('id'),
            name = $('.manufacturers-name-container[data-group=' + id + '] span.c-name').text();

        loadForm();
        $('#manufacturers-name-input').val(name);

        $('#modal .save-data').on('click', function () {
            var val = $('#manufacturers-name-input').val();
            ajaxSend.call(this,
                'GET',
                updateUrl, {
                    id: id,
                    manufacturers_name: val
                },
                function () {
                    $(this).off();
                    $('.manufacturers-name-container[data-group=' + id + ']').children('span.c-name').text(val);
                    throwNotification('Color ' + val + ' was updated successfully.', 'alert-success', 6000);
                }
            );
        });
    });

    $(document).on('click', '.manufacturers-delete', function (e) {
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
                        throwNotification('Color was removed successfully.', 'alert-success', 6000);
                    }
                );
                toDeleteLineObj.remove();
            }
        );

        throwPopupConfirm();
    });


})(jQuery);