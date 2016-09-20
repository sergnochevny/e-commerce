'use strict';
(function ($) {
    var base_url = $('#base_url').val();
    $(document)
        .off('.basket')
        .on('click.basket', 'a#to_basket',
            function (event) {
                event.preventDefault();
                var url = $(this).attr('href');
                var container = $(this).parent('figcaption');
                $('#content').waitloader('show');
                $.get(
                    url,
                    {},
                    function (answer) {
                        data = JSON.parse(answer);
                        $.when(
                            $('span#cart_amount').html(data.sum),
                            $(data.msg).appendTo('#content')
                        ).done(
                            function () {
                                if (data.button) {
                                    $(container).html(data.button)
                                }

                                $('#content').waitloader('remove');

                                buttons = {
                                    "Basket": function () {
                                        $(this).remove();
                                        $('#content').waitloader('show');
                                        window.location = base_url + 'cart';
                                    }
                                };

                                $('#msg').dialog({
                                    draggable: false,
                                    dialogClass: 'msg',
                                    title: 'Added to Basket',
                                    modal: true,
                                    zIndex: 10000,
                                    autoOpen: true,
                                    width: '500',
                                    resizable: false,
                                    buttons: buttons,
                                    close: function (event, ui) {
                                        $(this).remove();
                                    }
                                });
                                $('.msg').css('z-index', '10001');
                                $('.ui-widget-overlay').css('z-index', '10000');

                            }
                        );
                    }
                );
            }
        );
    $(document).on('click', '.page-numbers',
        function (event) {
            var search = $('#f_search_1').children('#search').val();
            if(search.trim().length > 0){
                event.preventDefault();
                var href = $(this).attr('href');
                $('#f_search_1').attr('action', href).trigger('submit');
            }
        }
    );

    $('#b_search_1').on('click',
        function (event) {
            $('#f_search_1').trigger('submit');
        }
    );

    $(document).on('click', '.a_search',
        function (event) {
            event.preventDefault();
            var href = $(this).attr('href');
            $('#f_search_1').attr('action', href).trigger('submit');
        }
    );

})(jQuery);