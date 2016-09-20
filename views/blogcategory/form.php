
<form id="blog_category_form" action="<?= $action_url;?>"  method="post">
    <small style="color: black; font-size: 10px;">
        Use this form to update the title and details of the offer.<br />
    </small>
    <div class="col-1">
        <p class="form-row"> <label class="required_field"><strong>Category:</strong></label>
            <input type="text" name="category" value="<?=$data['name']?>" class="input-text ">
        </p>
        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php if(isset($warning)){ foreach($warning as $msg){ echo $msg."<br/>"; } } ?>
        </div>
        <div class="col-xs-12 alert-danger danger" style="display: none;">
            <?php if(isset($error)){ foreach($error as $msg){ echo $msg."<br/>"; } } ?>
        </div>
        <br/>
        <br/>
        <div class="text-center"><input type="submit" value="<?= $button_title?>" class="button" /></div>
    </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blogcategory/form.js'); ?>' type="text/javascript"></script>