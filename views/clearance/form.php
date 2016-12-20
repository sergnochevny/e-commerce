<?php include_once 'views/messages/alert-boxes.php'; ?>

<input data-products_get_list type="hidden"
       value="<?= _A_::$app->router()->UrlTo('clearance', ['method' => 'add']) ?>"/>
<div data-products_block class="col-xs-12">
  <?= isset($search_form) ? $search_form : '' ?>
</div>
