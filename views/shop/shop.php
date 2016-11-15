<div class="container">
  <?= isset($shop_menu)?$shop_menu:'';?>
  <div id="content" class="main-content-inner" role="main">
    <?=$list;?>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/shop/shop.js'); ?>' type="text/javascript"></script>
	
    

