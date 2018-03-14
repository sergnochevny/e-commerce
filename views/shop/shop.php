<?php

use app\core\App;
use classes\helpers\AdminHelper;

?>
<?php //$this->registerCSSFile(App::$app->router()->UrlTo('css/shop_common.min.css')); ?>

<?php $is_admin = AdminHelper::is_logged(); ?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <?php if(!$is_admin): ?>
    <div class="col-xs-12 col-md-20-prc">
      <div class="row w_search">
        <?= isset($shop_menu) ? $shop_menu : ''; ?>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-xs-12 <?= $is_admin ? '' : 'col-md-80-prc' ?> main-content-inner-side box" role="main">
    <div id="content" class="content row">
      <?= $list; ?>
    </div>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/shop/shop.min.js'), 4); ?>
