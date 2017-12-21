<?php

use app\core\App;

?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 col-md-2">
    <div class="row w_search">
      <?= isset($shop_menu) ? $shop_menu : ''; ?>
    </div>
  </div>
  <div class="col-xs-12 col-md-10 pull-right main-content-inner-side box" role="main">
    <div id="content" class="content">
      <?= $list; ?>
    </div>
  </div>
</div>
<script src='<?= App::$app->router()->UrlTo('js/shop/shop.min.js'); ?>' type="text/javascript"></script>