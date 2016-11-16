<div class="container">
  <div class="col-xs-12 col-md-2">
    <div class="row wo_search">
      <?= isset($shop_menu) ? $shop_menu : ''; ?>
    </div>
  </div>
  <div class="col-xs-12 pull-right">
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
  <div class="col-xs-12 col-md-10 pull-right main-content-inner" role="main">
    <div id="content" class="row">
      <?= $list; ?>
    </div>
  </div>
</div>
