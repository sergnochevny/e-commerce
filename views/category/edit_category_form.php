
<form id="category_edit_form" action="<?php echo _A_::$app->router()->UrlTo('mnf') ?>/save_data_categories?category_id=<?php echo $_GET['category_id'];?>"  method="post">
    <small style="color: black; font-size: 10px;">
        Use this form to update the title and details of the offer.<br />
        NOTE: the title cannot be more than 28 characters.
    </small>
    <div class="col-1">
        <p class="form-row">
            <label class="required_field"><strong>Category:</strong></label>
            <input type="text" name="category" value="<?=$userInfo['cname']?>"
                   class="input-text ">
        </p>
        <p class="form-row">
            <label><strong>Display order:</strong></label>
            <select name="display_order">
                <?php echo $display_order_categories; ?>
            </select>

        </p>
        <p class="form-row">
            <label><strong>Seo:</strong></label>
            <input type="text" name="seo" value="<?=$userInfo['seo']?>" class="input-text ">
            <small><strong>NOTE:</strong> the seo name will be parsed to be url compatible if necessary.</small>
        </p>

        <p class="form-row">
            <label><strong>List as a Style:</strong></label>
            <?php
            if($userInfo['isStyle']=="1")
            {echo '<input type="checkbox" name="ListStyle" checked="checked" value="1" class="input-checkbox">';}
            else
            {echo '<input type="checkbox" name="ListStyle" value="1" class="input-checkbox">';}
            ?>

        </p>
        <p class="form-row">
            <label><strong>List as a New Item:</strong></label>
            <?php
            if($userInfo['isNew']=="1")
            {echo '<input type="checkbox" name="ListNewItem" checked="checked" value="1" class="input-checkbox">';}
            else
            {echo '<input type="checkbox" name="ListNewItem" value="1" class="input-checkbox">';}
            ?>
        </p>

        <!--col-2-->
        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php
            if(isset($warning)){
                foreach($warning as $msg){
                    echo $msg."\r\n";
                }
            }
            ?>
        </div>
        <div class="col-xs-12 alert-danger danger" style="display: none;">
            <?php
            if(isset($error)){
                foreach($error as $msg){
                    echo $msg."\r\n";
                }
            }
            ?>
        </div>
        <br/>
        <br />
        <center><input type="submit" value="Update" class="button" /></center>

</form>
<script type="text/javascript">
    (function($){
        $("#category_edit_form").on('submit',
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