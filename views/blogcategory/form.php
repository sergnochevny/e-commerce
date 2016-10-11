<form id="edit_form" action="<?=$action?>" data-title="<?=$form_title?>">
    <div class="form-row">
        <label for="colour">Category Name</label>
        <input type="text" class="input-text" name="name" value="<?=$data['name'];?>">
    </div>
    <div class="form-row">
        <label for="colour">Category Slug</label>
        <input type="text" class="input-text" name="slug" value="<?=$data['slug'];?>">
    </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.js'); ?>' type="text/javascript"></script>
