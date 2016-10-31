<div class="row cart_item table-list-row-item" data-pid="<?= $pid; ?>" data-row="samples">
  <div class="col-sm-6">
    <div class="row">
      <div class="col-sm-4">
        <?php
          $href = _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart'], $item['Product_name']);
        ?>
        <a href="<?= $href; ?>">
          <img alt="" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" src="<?= $img_url; ?>">
        </a>
      </div>
      <div class="col-sm-8">
        <a href="<?= $href; ?>">
          <?= $item['Product_name']; ?>
        </a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <span class="quantity"><?= $item['quantity']; ?></span>
  </div>
  <div class="col-sm-2">
    <a class="del_sample_cart" href="<?= _A_::$app->router()->UrlTo('cart/del_sample'); ?>">
      <i class="fa fa-trash-o"></i>
    </a>
  </div>
</div>
