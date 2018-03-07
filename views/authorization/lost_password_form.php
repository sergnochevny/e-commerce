<?php

use app\core\App;

?>
<article class="page type-page status-publish entry">
  <br>
  <br>
  <h1 class="entry-title">Lost Password?</h1>

  <div class="entry-content" style="padding-bottom: 0;">
    <ul>
      <li>Identity your Email Address(Login).</li>
      <li>Click on the button &laquo;Send&raquo;.</li>
      <li>It will be sent an email with a link inside to a form that will help you to change your password.</li>
      <li>Receive a email and click to the link.</li>
      <li>Change your password using the form.</li>
    </ul>
    <span style="color: red;">Be careful, the link is relevant only one hour.</span>
  </div>

  <?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>

  <div class="entry-content">
    <div class="woocommerce">
      <form method="POST" id="lost_password_form" action="<?= $action; ?>"
            class="login">

        <p class="form-row form-row-wide">
          <label for="username">Email Address <span class="required">*</span></label>
          <input type="text" class="input-text" name="login" id="username" value="" autofocus/>
        </p>

        <p class="form-row">
          <input id="blost" type="button" class="button" name="login" value="Send"/>
        </p>

        <div class="text-center">
          <div class="results" style="color: red;"></div>
        </div>
      </form>
    </div>
  </div>

</article>

<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/lost_password_form.min.js'), 5, true); ?>

