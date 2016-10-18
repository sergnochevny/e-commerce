<form id="edit_form" action="<?= $action ?>" method="post"  data-title="<?=$form_title?>">
  <div class="row">
    <div class="col-md-12">
      <div class="form-row">
        <label class="required_field"><strong>Title:</strong></label>
        <input type="text" name="colour" value="<?= $data['title'] ?>" class="input-text ">
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-row">
        <label class="required_field"><strong>Content:</strong></label>
        <textarea name="colour" class="input-text" style="height: 180px"><?= $data['data'] ?></textarea>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-row">
        <label class="required_field"><strong>Moderated:</strong></label>
        <select name="moderated" id="">
          <option value="">Please, moderate the comment</option>
          <option value="1" <?= $data['moderated'] == 1 ? 'selected' : '' ?>>Published</option>
          <option value="0" <?= $data['moderated'] == 0 ? 'selected' : '' ?>>Hidden</option>
        </select>
      </div>
    </div>
  </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.js'); ?>' type="text/javascript"></script>