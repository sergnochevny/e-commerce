<tr class="cart_item" data-pid="<?= $p_id; ?>" data-row="items">
    <td class="product-thumbnail" style="padding: 0">
        <a href="<?= _A_::$app->router()->UrlTo('product',['p_id'=>$p_id,'back'=>'cart']); ?>">
            <img width="110" height="110" alt="" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
                 src="<?= $img_url; ?>">
        </a>
    </td>
    <td data-title="Product" class="product-name">
        <a href="<?= _A_::$app->router()->UrlTo('product',['p_id'=>$p_id,'back'=>'cart']); ?>"><?= $item['Product_name']; ?></a>
    </td>
    <td data-title="Price" class="product-price">
        <span class="amount"><?= $item['format_price']; ?></span>
    </td>
    <td data-title="Discount" class="product-discount">
        <span class="discount"><?= $item['format_discount'];; ?></span>
    </td>
    <td data-title="Sale Price" class="product-price" >
        <span class="amount"><?= $item['format_sale_price']; ?> </span>
    </td>
    <td data-title="Quantity" class="product-quantity">
        <div class="quantity">
            <?php if($item['piece'] == 0){?>
            <input data-role="quantity" data-whole="<?= ($item['whole'] == 1?'1':'0')?>" type="number" min="1" max="100000" class="qty text" title="Quantity" value="<?= $item['quantity']; ?>">
            <?php } else {?>
                <span class="quantity"><?= $item['quantity']; ?></span>
            <?php }?>
        </div>
    </td>
    <td data-title="Total" class="product-subtotal">
        <span class="amount"><?= $t_pr; ?></span>
    </td>
    <td class="product-remove text-center">
        <a class="del_product_cart" href="<?= _A_::$app->router()->UrlTo('cart/del_product');?>">
            <i class="fa fa-trash-o"></i>
        </a>
    </td>
</tr>
