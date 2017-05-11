<?php $href = _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart'], $item['pname']); ?>
<div class="col-xs-12 table-list-row" data-block="sample_item" data-pid="<?= $pid; ?>" data-row="samples">
  <div class="col-xs-12 col-sm-6 table-list-row-item">
    <div class="row">
      <a href="<?= $href; ?>">SAMPLE - <?= $item['pname']; ?></a>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 col-sm-offset-2 table-list-row-item">
    <div class="row">
      <div class="col-xs-4 visible-xs">
        <div class="row"><b>Quantity:</b></div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row">
          <?= $item['quantity']; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-1 col-sm-offset-1 table-list-row-item text-right action-buttons">
    <div class="row">
      <a data-block="del_sample_cart" href="<?= _A_::$app->router()->UrlTo('cart/del_sample'); ?>"><i
          class="fa fa-2x fa-trash-o"></i></a>
    </div>
  </div>
</div>