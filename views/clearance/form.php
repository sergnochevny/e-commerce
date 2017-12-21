<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>

<input data-products_get_list type="hidden"
       value="<?= App::$app->router()->UrlTo('clearance', ['method' => 'add']) ?>"/>
<div data-products_block class="col-xs-12">
  <?= isset($search_form) ? $search_form : '' ?>
</div>
