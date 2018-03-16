<?php

use app\core\App;

/**
 * @var \app\core\Template $this
 */
?>

<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <?php if(!empty($info_view)):?>
  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical">
    <div class="block-info">
      <?= $info_view; ?>
    </div>
  </div>
  <?php endif;?>
  <?php if(!empty($shop_widget_under)):?>
  <div class="col-xs-12 box inner-offset-top half-outer-offset-bottom">
    <div>
      <?= $shop_widget_under;?>
    </div>
  </div>
  <?php endif;?>
  <?php if(!empty($shop_widget_carousel_specials)):?>
  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical specials-products-container">
    <?= $shop_widget_carousel_specials; ?>
  </div>
  <?php endif;?>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/load.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/index/index.min.js'), 4); ?>
