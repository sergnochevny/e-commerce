<?php

use app\core\App;
use controllers\ControllerUser;

$controller_user = new ControllerUser($this->controller->get_main());
App::$app->get('method', 'short');
$user_registration = $controller_user->registration();
?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="row">

    <div class="col-xs-12 col-sm-12 text-center">
      <label>To enable all features of iluvfabrix.com please register</label>
    </div>

    <div class="col-xs-12 col-md-8 col-md-offset-2 panel-default-vertical-sizing">
      <div class="col-xs-12 panel panel-default">
        <div class="row">
          <div class="col-xs-12 text-center">
            <h4>Register with iluvfabrix:</h4>
          </div>
          <div class="col-xs-12" data-role="form_content">
            <div>
              <?= $user_registration;?>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/load.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/captcha/captcha.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/registration/script.min.js'), 4); ?>
