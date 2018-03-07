<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">

  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical">
    <div class="block-info">
      <div data-load="<?= App::$app->router()->UrlTo('info/view', ['method' => 'home']) ?>"></div>
    </div>
  </div>

  <div class="col-xs-12 box inner-offset-top half-outer-offset-bottom">
    <div>
      <div data-load="<?= App::$app->router()->UrlTo('shop/widget', ['type' => 'under']) ?>"></div>
    </div>
  </div>

  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical specials-products-container">
    <input type="hidden" id="specials-products_url"
           value="<?= App::$app->router()->UrlTo('shop/widget', ['type' => 'carousel_specials']); ?>">
  </div>

</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/load.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/index/index.min.js'), 4); ?>
