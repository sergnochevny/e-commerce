<tr class="cart_item" data-pid="<?php echo $p_id; ?>" data-row="items">
    <td class="product-thumbnail">
        <a href="<?php echo _A_::$app->router()->UrlTo('product',['p_id'=>$p_id,'back'=>'cart']); ?>">
            <img width="110" height="110" alt="" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
                 src="<?php echo $img_url; ?>">
        </a>
    </td>
    <td data-title="Product" class="product-name">
        <a href="<?php echo _A_::$app->router()->UrlTo('product',['p_id'=>$p_id,'back'=>'cart']); ?>"><?php echo $item['Product_name']; ?></a>
    </td>
    <td data-title="Price" class="product-price">
        <span class="amount"><?php echo $item['format_price']; ?></span>
    </td>
    <td data-title="Discount" class="product-discount">
        <span class="discount"><?php echo $item['format_discount'];; ?></span>
    </td>
    <td data-title="Sale Price" class="product-price" >
        <span class="amount"><?php echo $item['format_sale_price']; ?> </span>
    </td>
    <td data-title="Quantity" class="product-quantity">
        <div class="quantity">
            <?php if($item['piece'] == 0){?>
            <input data-role="quantity" data-whole="<?php echo ($item['whole'] == 1?'1':'0')?>" type="number" min="1" max="100000" class="qty text" title="Quantity" value="<?php echo $item['quantity']; ?>">
            <?php } else {?>
                <span class="quantity"><?php echo $item['quantity']; ?></span>
            <?php }?>
        </div>
    </td>
    <td data-title="Total" class="product-subtotal">
        <span class="amount"><?php echo $t_pr; ?></span>
    </td>
    <td class="product-remove">
        <a id="del_product_cart" href="<?php echo _A_::$app->router()->UrlTo('cart/del_product');?>">
            <i class=" fa fa-trash-o"></i>
        </a>
    </td>
</tr>
