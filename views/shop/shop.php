<div class="container">
  <div class="col-xs-12 col-md-2">
    <div class="row w_search">
      <?= isset($shop_menu) ? $shop_menu : ''; ?>
    </div>
  </div>
  <div class="col-xs-12 col-md-10 col-sm-offset-2 main-content-inner" role="main">
    <div id="content" class="row">
      <?=$list;?>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/shop/shop.js'); ?>' type="text/javascript"></script>
	
    

