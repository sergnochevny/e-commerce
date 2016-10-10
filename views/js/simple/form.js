(
    function($){

        $('#modal .save-data').on('click',
            function(event){
                event.preventDefault();
                $('#edit_form').trigger('submit');
                $('#modal .save-data').off();
            }
        );

        $('#modal-title').html($('#edit_form').attr('data-title'));
        $('#modal').modal('show');


        $('#edit_form').on('submit',
            function (event) {
                event.preventDefault();
                $('body').waitloader('show');
                var url = $(this).attr('action');
                var data = new FormData(this);
                $('#modal').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $.when($('#content').html(data)).done(
                            function () {
                                $('body').waitloader('remove');
                            }
                        );
                    },
                    error: function (xhr, str) {
                        alert('Error: ' + xhr.responseCode);
                        $('body').waitloader('remove');
                    }
                });
            }
        );
    }
)(jQuery);
