<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/messages/thanx-boxes-registration.php'); ?>
<form id="edit_form" action="<?= $action ?>" method="post" class="index__form-wrap">
  <input type="hidden" name="redirect"
         value="<?= isset($redirect) ? $redirect : App::$app->router()->UrlTo('/'); ?>"/>
  <div class="form-row">
    <div class="col-xs-12">
      <div class="row">
        <input type="text" name="bill_firstname"
               value="<?= isset($data['bill_firstname']) ? $data['bill_firstname'] : ''; ?>" class="input-text"
               placeholder="First Name">
      </div>
    </div>
    <div class="col-xs-12">
      <div class="row">
        <input type="text" name="bill_lastname"
               value="<?= isset($data['bill_lastname']) ? $data['bill_lastname'] : ''; ?>" class="input-text"
               placeholder="Last Name">
      </div>
    </div>
    <div class="col-xs-12">
      <div class="row">
        <input type="email" name="email" value="<?= isset($data['email']) ? $data['email'] : ''; ?>" class="input-text"
               placeholder="Enter Email">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <input type="password" name="create_password" class="input-text" placeholder="Password">
      </div>
      <div class="col-xs-12 col-sm-6">
        <input type="password" name="confirm_password" class="input-text" placeholder="Confirm Password">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6">
        <img height="45" id="captcha_img" src="<?= App::$app->router()->UrlTo('captcha') ?>">
        <a class="pull-right half-inner-offset-top" tabindex="-1" title="Refresh" id="captcha_refresh"
           href="javascript:void(0);">
          <i class="fa fa-2x fa-refresh" aria-hidden="true"></i>
        </a>
      </div>
      <div class="col-xs-6 col-sm-6">
        <input type="text" name="captcha" class="input-text" placeholder="Enter Text from image">
      </div>
    </div>
  </div>
  <div class="col-xs-12 text-center">
    <div class="row">
      <input type="button" data-role="submit" class="btn button" value="Register">
    </div>
  </div>
</form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/registration/form.min.js'), 5);?>
