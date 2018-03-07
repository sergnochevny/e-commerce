<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>
<h1 class="entry-title">Change Password</h1>
<div class="entry-content">
  <div class="woocommerce">
    <form method="POST" id="psw_form" action="<?= $action; ?>" class="login">
      <input type="hidden" name="remind" value="<?= isset($remind) ? $remind : ''; ?>"/>

      <p class="form-row form-row-wide">
        <label for="password">Password <span class="required">*</span></label>
        <input class="input-text" type="password" name="password" id="password"/>
      </p>

      <p class="form-row form-row-wide">
        <label for="confirm">Confirm Password<span class="required">*</span></label>
        <input type="password" class="input-text" name="confirm" id="confirm"/>
      </p>

      <p class="form-row">
        <input id="bchange" type="button" class="button" value="Change"/>
      </p>
    </form>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/remind/change_password_form.min.js'), 5, true)
; ?>