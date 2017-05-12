<?php include('views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">

  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical">
    <div class="col-xs-12">
      <div class="row"
           data-load="<?= _A_::$app->router()->UrlTo('info/view', ['method' => 'home']) ?>">
      </div>
    </div>
  </div>

  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical">
    <h3 class="section-title">Specials</h3>
    <div class="col-xs-12">
      <div class="row">
        <div class="products special-products owl-carousel"></div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 box outer-offset-bottom inner-offset-vertical">
    <h3 class="section-title">Best Sellers</h3>
    <div class="row products best-products"></div>
    <div class="row bestseller-action-row">
      <div class="col-xs-12 text-center">
        <a href="<?= _A_::$app->router()->UrlTo('shop/bestsellers'); ?>" class="button button-2x">MORE</a>
      </div>
    </div>
  </div>

</div>

<input type="hidden" id="get_url" value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'carousel']); ?>">
<input type="hidden" id="slider_url"
       value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'bsells_horiz']); ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/index/index.min.js'); ?>' type="text/javascript"></script>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/load.min.js'); ?>'></script>
