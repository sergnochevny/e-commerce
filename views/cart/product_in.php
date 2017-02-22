<?php /** @noinspection PhpUndefinedMethodInspection */
  $href = _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart'], $item['pname']); ?>
<div class="col-xs-12 table-list-row" data-block="cart_item" data-pid="<?= $pid; ?>" data-row="items">
  <div class="col-xs-12 col-sm-4 table-list-row-item">
    <div class="row">
      <a href="<?= $href ?>"><?= $item['pname']; ?></a>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 table-list-row-item">
    <div class="row">
      <div class="col-xs-6 visible-xs">
        <div class="row"><b>Price:</b></div>
      </div>
      <div class="col-xs-6 col-sm-12">
        <div class="row">
          <span class="amount"><?= $item['format_price']; ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 table-list-row-item">
    <div class="row">
      <div class="col-xs-6 visible-xs">
        <div class="row"><b>Discount:</b></div>
      </div>
      <div class="col-xs-6 col-sm-12">
        <div class="row"><?= $item['format_discount']; ?></div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 table-list-row-item">
    <div class="row">
      <div class="col-xs-6 visible-xs">
        <div class="row"><b>Quantity:</b></div>
      </div>
      <div class="col-xs-6 col-sm-12">
        <div class="row">
          <div class="quantity">
            <?php if($item['piece'] == 0) { ?>
              <input data-role="quantity" data-whole="<?= ($item['whole'] == 1 ? '1' : '0') ?>" type="text" min="1"
                     max="100000" class="qty text input-text input-for-spinner" title="Quantity"
                     value="<?= $item['quantity']; ?>">
            <?php } else { ?>
              <span class="quantity"><?= $item['quantity']; ?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-1 table-list-row-item">
    <div class="row">
      <div class="col-xs-6 visible-xs">
        <div class="row"><b>Total:</b></div>
      </div>
      <div class="col-xs-6 col-sm-12">
        <div class="row"><span class="amount"><?= $t_pr; ?></span></div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
    <a data-block="del_product_cart" href="<?= /** @noinspection PhpUndefinedMethodInspection */
      _A_::$app->router()->UrlTo('cart/del_product'); ?>">
      <i class="fa fa-2x fa-trash-o"></i>
    </a>
  </div>
</div>