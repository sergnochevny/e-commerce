<div class="row cart_item table-list-row-item" data-pid="<?= $pid; ?>" data-row="samples">
  <div class="col-sm-10">
    <div class="row">
      <div class="col-sm-2">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart']); ?>">
          <img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
               src="<?= $img_url; ?>">
        </a>
      </div>
      <div class="col-sm-10">
        SAMPLE - <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart']); ?>">
          <?= $item['Product_name']; ?>
        </a>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <span class="quantity"><?= $item['quantity']; ?></span>
  </div>
</div>
