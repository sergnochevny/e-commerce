<?php

use app\core\App;

?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="row">
    <div class="col-xs-12 box">
      <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
        Back
      </a>
      <div id="chng_pass" class="page type-page status-publish entry">
        <?php include(APP_PATH . '/views/authorization/remind/change_password_form.php'); ?>
      </div>
    </div>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/remind/change_password.min.js'), 4); ?>