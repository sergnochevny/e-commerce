<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">

  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical">
    <div>
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

  <!--  <div class="col-xs-12 box outer-offset-bottom inner-offset-vertical">-->
  <!--    <h3 class="section-title">Best Sellers</h3>-->
  <!--    <div class="row products best-products">-->
  <!--      <div data-load="-->
  <? //= App::$app->router()->UrlTo('shop/widget', ['type' => 'bsells_horiz']); ?><!--"></div>-->
  <!--    </div>-->
  <!--    <div class="row bestseller-action-row">-->
  <!--      <div class="col-xs-12 text-center">-->
  <!--        <a href="-->
  <? //= App::$app->router()->UrlTo('shop/bestsellers'); ?><!--" class="button button-2x">MORE</a>-->
  <!--      </div>-->
  <!--    </div>-->
  <!--  </div>-->

</div>
<script type='text/javascript' src='<?= App::$app->router()->UrlTo('js/load.min.js'); ?>'></script>
<script src='<?= App::$app->router()->UrlTo('js/index/index.min.js'); ?>' type="text/javascript"></script>
