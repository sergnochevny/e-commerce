<?php

use app\core\App;

?>
<form id="edit_form" action="<?= $action ?>" method="post" data-title="<?= $form_title ?>">
  <div class="row">
    <div class="col-xs-12">
      <div class="form-row">
        <label class="required_field"><strong>Color Name:</strong></label>
        <input type="text" name="color" value="<?= $data['color'] ?>" class="input-text ">
      </div>
    </div>
  </div>
</form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/simple/form.min.js'), 5); ?>