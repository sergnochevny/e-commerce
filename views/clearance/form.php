<?php include_once 'views/messages/alert-boxes.php'; ?>
<form id="edit_form" action="<?= $action ?>" method="post">

</form>

<div data-products_block class="col-xs-12">
  <div class="col-xs-12 panel panel-default" style="padding-bottom: 30px">
    <input data-products_get_list type="hidden"
           value="<?= _A_::$app->router()->UrlTo('clearance', ['method' => 'add']) ?>"/>
    <div id="content" data-edit_products class="row products"></div>
  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/clearance/form.js'); ?>' type="text/javascript"></script>
