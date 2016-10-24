<?php include_once 'views/messages/alert-boxes.php'; ?>
<form id="edit_form" action="<?= $action ?>" method="post">

  <h3 class="page-title"><?= $form_title ?></h3>

  <div class="col-1">
    <p class="form-row">
      <label class="required_field"><strong>Login:</strong></label>
      <input type="text" name="login" value="<?= $data['login'] ?>"
             class="input-text ">
    </p>

    <p class="form-row">
      <label><strong>Password:</strong></label>
      <input type="password" name="create_password"
             class="input-text ">
    </p>

    <p class="form-row">
      <label><strong>Confirm Password:</strong></label>
      <input type="password" name="confirm_password"
             class="input-text ">
    </p>
    <div class="text-center">
      <input type="submit" value="SAVE" class="button"/>
    </div>
  </div>
</form>
<input type="hidden" id="base_url" value="<?= _A_::$app->router()->UrlTo('/') ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/form.js'); ?>' type="text/javascript"></script>