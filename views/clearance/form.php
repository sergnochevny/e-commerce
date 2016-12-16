<?php include_once 'views/messages/alert-boxes.php'; ?>

<div data-products_block class="col-xs-12">
  <div class="col-xs-12 panel panel-default" style="padding-bottom: 30px">
    <?php $prms = ['method' => 'add']; ?>
    <input data-products_get_list type="hidden"
           value="<?= _A_::$app->router()->UrlTo('clearance', $prms) ?>"/>
    <div data-edit_products class="row products">
      <?= isset($search_form) ? $search_form : '' ?>
    </div>
  </div>
</div>
