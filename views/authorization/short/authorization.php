<?php

use app\core\App;

?>
<div class="col-xs-12 inner-offset-vertical">
  <div class="row text-center inner-offset-vertical-bottom">
    <label>To enable all features of iluvfabrix.com please register or sign-in below</label>
  </div>
  <div class="row">
    <form method="post" id="short_authorization" action="<?= App::$app->router()->UrlTo('authorization'); ?>"
          class="login">
      <input type="hidden" name="redirect" value=""/>

      <div class="form-row">
        <label for="username" class="required_field">Email Address/Username</label>
        <input type="text" class="input-text" name="login" value="" autofocus/>
      </div>

      <div class="form-row form-row-wide">
        <label for="password" class="required_field">Password</label>
        <input class="input-text" type="password" name="pass"/>
      </div>

      <div class="row">
        <div class="col-xs-6">
          <input data-link id="short_login" type="submit" class="button" value="Login"/>
        </div>
        <div class="col-xs-6 text-right">
          <label for="rememberme" class="inline">
            Remember me
            <input class="rememberme" name="rememberme" value="1" type="checkbox" id="short_rememberme"/>
          </label>
        </div>
      </div>

      <div class="col-xs-12">
        <div class="row text-center">
          <div class="results" style="color: red;"></div>
        </div>
      </div>
    </form>
  </div>
  <div class="row inner-offset-vertical-top">
    <div class="col-xs-6">
      <div class="row">
        <a data-waitloader href="<?= $lostpassword_url ?>">Lost your password?</a>
      </div>
    </div>
    <div class="col-xs-6 text-right">
      <div class="row">
        <a data-waitloader href="<?= $registration_url ?>">Registration</a>
      </div>
    </div>
  </div>
</div>
<script src='<?= App::$app->router()->UrlTo('js/authorization/short_authorization.min.js'); ?>'
        type="text/javascript"></script>
