<?php $is_admin = Controller_Admin::is_logged(); ?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <?php if(!$is_admin): ?>
    <div class="col-xs-12 col-md-2">
      <div class="row w_search">
        <?= isset($shop_menu) ? $shop_menu : ''; ?>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-xs-12 <?= $is_admin ? '' : 'col-md-10' ?> main-content-inner box" role="main">
    <div id="content" class="content row">
      <?= $list; ?>
    </div>
  </div>
</div>
<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/shop/shop.min.js'); ?>' type="text/javascript"></script>