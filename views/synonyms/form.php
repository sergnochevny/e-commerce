<form id="edit_form" action="<?= $action ?>" method="post" data-title="<?= $form_title ?>">
  <div class="row">
    <div class="col-xs-12">
      <p>
        Use this form to add keywords and their synonyms. The system will search for the synonyms and the keyword.
        <br><small>NOTE: to add multiple keywords/synonyms, use a comma ",".</small>
      </p>
    </div>
    <div class="col-xs-12">
      <div class="form-row">
        <label class="required_field"><strong>Keywords:</strong></label>
        <textarea name="keywords" class="input-text"><?= $rows['keywords'] ?></textarea>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="form-row">
        <label class="required_field"><strong>Synonyms:</strong></label>
        <textarea name="synonyms" class="input-text"><?= $rows['synonyms'] ?></textarea>
      </div>
    </div>
  </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.min.js'); ?>' type="text/javascript"></script>