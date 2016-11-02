<?php $href = _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart'], $item['Product_name']); ?>
<div class="col-xs-12 table-list-row" data-block="cart_item" data-pid="<?= $pid; ?>" data-row="items">
  <div class="row">
    <div class="col-xs-12 col-sm-6 table-list-row-item">
      <div class="row">
        <div class="col-sm-5">
          <img alt=""
               class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
               src="<?= $img_url; ?>">
        </div>
        <div class="col-sm-7">
          <div class="row">
            <a href="<?= $href ?>"><?= $item['Product_name']; ?></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 table-list-row-item">
      <div class="col-xs-4 visible-xs helper-row">
        <div class="row">Price</div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row"><span class="amount"><?= $item['format_price']; ?></span></div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 table-list-row-item">
      <div class="col-xs-4 visible-xs helper-row">
        <div class="row">Quantity</div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row">
          <div class="quantity">
              <span class="quantity"><?= $item['quantity']; ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 table-list-row-item">
      <div class="col-xs-4 visible-xs helper-row">
        <div class="row">Total</div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row"><span class="amount"><?= $t_pr; ?></span></div>
      </div>
    </div>
  </div>
</div>
