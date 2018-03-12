<?php

use app\core\App;
use controllers\ControllerInfo;
use controllers\ControllerShop;

/**
 * @var \app\core\Template $this
 * @var \controllers\ControllerShop $this ->controller
 */
$controller_info = new ControllerInfo($this->controller->get_main());
$controller_shop = new ControllerShop($this->controller->get_main());
?>
<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">

  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical">
    <div class="block-info">
      <?= $controller_info->view(false, false, true); ?>
    </div>
  </div>

  <div class="col-xs-12 box inner-offset-top half-outer-offset-bottom">
    <div>
      <?= $controller_shop->widget('under'); ?>
    </div>
  </div>

  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical specials-products-container">
    <?= $controller_shop->widget('carousel_specials'); ?>
  </div>

</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/load.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/index/index.min.js'), 4); ?>
