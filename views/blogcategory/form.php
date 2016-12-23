<form id="edit_form" action="<?=$action?>" data-title="<?=$form_title?>">
    <div class="form-row">
        <label for="color">Category Name</label>
        <input type="text" class="input-text" name="name" value="<?=$rows['name'];?>">
    </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.min.js'); ?>' type="text/javascript"></script>
