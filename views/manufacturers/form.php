<form id="edit_form" action="<?=$action?>" data-title="<?=$form_title?>">
  <div class="form-row">
    <label for="manufacturer">Manufacturer</label>
    <input type="text" class="input-text" name="manufacturer" value="<?=$data['manufacturer'];?>">
  </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.js'); ?>' type="text/javascript"></script>
