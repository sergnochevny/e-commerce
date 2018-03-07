<?php

use app\core\App;

?>
<form id="edit_form" action="<?= $action ?>" method="post" data-title="<?= $form_title ?>">
  <div class="row">
    <div class="col-xs-12">
      <p>
        Use this form to add keywords and their synonyms. The system will search for the synonyms and the keyword.
        <br>
        <small class="note"><b>NOTE:</b> to add multiple keywords/synonyms, use a comma ",".</small>
      </p>
    </div>
    <div class="col-xs-12">
      <div class="form-row">
        <label class="required_field"><strong>Keywords:</strong></label>
        <textarea name="keywords" class="input-text"><?= $data['keywords'] ?></textarea>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="form-row">
        <label class="required_field"><strong>Synonyms:</strong></label>
        <textarea name="synonyms" class="input-text"><?= $data['synonyms'] ?></textarea>
      </div>
    </div>
  </div>
</form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/simple/form.min.js'), 5, true); ?>