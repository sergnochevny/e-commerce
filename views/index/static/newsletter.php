<?php

use app\core\App;
use classes\helpers\UserHelper;
use controllers\ControllerUser;

$controller_user = new ControllerUser($this->controller->get_main());
$controller_user->scenario('short');
?>
<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 box">

    <?php if(empty($back_url)) {
      $to_shop = true;
      $back_url = App::$app->router()->UrlTo('shop');
    } ?>

    <div class="col-xs-12 col-sm-2 back_button_container">
      <div class="row">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          <?= !empty($to_shop) ? 'To Shop' : 'Back' ?>
        </a>
      </div>
    </div>
    <div class="col-xs-12 <?= empty($back_url) ? '' : 'col-sm-8' ?>  text-center">
      <h1 class="page-title">I Luv Fabrix Newsletter</h1>
      <h2 class="page-title">
        <small>DESIGNER UPHOLSTERY/ DRAPERY FABRIC SUPERSALE</small>
      </h2>
    </div>

    <?php if(!UserHelper::is_logged()): ?>
      <div class="col-xs-12">
        <div class="row">
          <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <h4>Register for our newsletter to benefit from:</h4>
            <ul>
              <li>exclusive offers only given to members</li>
              <li> first to know of any limited time fabric discounts</li>
              <li>new features & website tools</li>
            </ul>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <div class="row">
                  <div class="col-xs-12" data-role="form_content">
                    <div>
                      <?= $controller_user->registration()?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/static/static.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/load.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/captcha/captcha.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/registration/script.min.js'), 4); ?>

