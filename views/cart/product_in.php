<div class="row cart_item table-list-row-item" data-pid="<?= $pid; ?>">
  <div class="col-sm-5">
    <div class="row">
      <div class="col-sm-4">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart']); ?>">
          <img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
               src="<?= $img_url; ?>">
        </a>
      </div>
      <div class="col-sm-8">
        <a
          href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart']); ?>">
          <?= $item['Product_name']; ?>
        </a>
      </div>
    </div>
  </div>
  <div class="col-sm-1"><?= $item['format_discount']; ?></div>
  <div class="col-sm-2"><?= $item['format_sale_price']; ?></div>
  <div class="col-sm-2">
    <?php if ($item['piece'] == 0) { ?>
      <input data-role="quantity"
             data-whole="<?= ($item['whole'] == 1 ? '1' : '0') ?>" min="1"
             max="100000" class="qty input-text" title="Quantity" value="<?= $item['quantity']; ?>">
    <?php } else { ?>
      <span class="quantity"><?= $item['quantity']; ?></span>
    <?php } ?>
  </div>
  <div class="col-sm-1">
    <span class="amount"><?= $t_pr; ?></span>
  </div>
  <div class="col-sm-1 text-center">
    <a class="del_product_cart" href="<?= _A_::$app->router()->UrlTo('cart/del_product'); ?>">
      <i class="fa fa-trash-o text-danger"></i>
    </a>
  </div>
</div>
