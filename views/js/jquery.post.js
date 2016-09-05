
    function call() {
      var msg   = $('#formx').serialize();
        $.ajax({
          type: 'POST',
          url: 'LoginInfoTest',
          data: msg,
          success: function(data) {
            $('.results').html(data);
          },
          error:  function(xhr, str){
                alert('Error: ' + xhr.responseCode);
            }
        });
 
    }
