
<form id="blog_category_form" action="<?php echo $action_url;?>"  method="post">
    <small style="color: black; font-size: 10px;">
        Use this form to update the title and details of the offer.<br />
    </small>
    <div class="col-1">
        <p class="form-row">
            <label class="required_field"><strong>Category:</strong></label>
            <input type="text" name="category" value="<?=$userInfo['name']?>"
                   class="input-text ">
        </p>

        <!--col-2-->
        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php
            if(isset($warning)){
                foreach($warning as $msg){
                    echo $msg."<br/>";
                }
            }
            ?>
        </div>
        <div class="col-xs-12 alert-danger danger" style="display: none;">
            <?php
            if(isset($error)){
                foreach($error as $msg){
                    echo $msg."<br/>";
                }
            }
            ?>
        </div>
        <br/>
        <br />
        <center><input type="submit" value="<?php echo $button_title?>" class="button" /></center>

</form>
<script type="text/javascript">
    (function($){
        $("#blog_category_form").on('submit',
            function(event){
                event.preventDefault();
                var url = $(this).attr('action');
                $.post(
                    url,
                    $(this).serialize(),
                    function(data){
                        $("#category_form").html(data);
                        $('.danger').css('display','block');
                        $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
                        setTimeout(function(){
                            $('.danger').css('display','none');
                        },8000);
                    }
                )

            }
        );
    })(jQuery);
</script>