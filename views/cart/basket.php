<?php

use app\core\App;

?>
<a data-waitloader class="button productsAddBasket" href="<?= App::$app->router()->UrlTo('cart'); ?>">
  <i class="simple-icon-handbag fa-2x"></i>
  Cart
</a>