<div class="container">
  <?= isset($shop_menu) ? $shop_menu : ''; ?>
  <div class="col-xs-12">
    <div class="row afterhead-row">
      <div class="col-sm-2 back_button_container">
        <div class="row">
          <a data-waitloader id="back_url" href="<?= _A_::$app->router()->UrlTo('shop'); ?>" class="button back_button">Back</a>
        </div>
      </div>
      <div class="col-sm-10 text-center">
        <div class="row">
          <h3 class="page-title">Manufacturer</h3>
        </div>
      </div>
    </div>
  </div>
  <div id="content" class="main-content-inner" role="main">
    <?= $list; ?>
  </div>
</div>
