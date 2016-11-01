<?php $href = _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart'], $item['Product_name']); ?>
<div class="col-xs-12 table-list-row" data-block="cart_item" data-pid="<?= $pid; ?>" data-row="items">
  <div class="row">
    <div class="col-xs-12 col-sm-4 table-list-row-item">
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
        <div class="row">Discount</div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row"><?= $item['format_discount']; ?></div>
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
    <div class="col-xs-12 col-sm-1 table-list-row-item">
      <div class="col-xs-4 visible-xs helper-row">
        <div class="row">Total</div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row"><span class="amount"><?= $t_pr; ?></span></div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
      <a class="del_product_cart" href="<?= _A_::$app->router()->UrlTo('cart/del_product'); ?>">
        <i class="fa fa-trash-o"></i>
      </a>
    </div>
  </div>
</div>

<!--<tr class="cart_item" data-pid="--><?// $pid; ?><!--" data-row="items">-->
<!--  <td data-title="Product" class="product-name"><a>--><?// $item['Product_name']; ?><!--</a></td>-->
<!--  <td data-title="Sale Price" class="product-price"><span class="amount">--><?// $item['format_sale_price']; ?><!--</span></td>-->
<!--  <td data-title="Quantity" class="product-quantity">-->
<!--    <div class="quantity"><span class="quantity">--><?// $item['quantity']; ?><!--</span></div>-->
<!--  </td>-->
<!--  <td data-title="Total" class="product-subtotal"><span class="amount">--><?// $item['format_subtotal']; ?><!--</span></td>-->
<!--</tr>-->
