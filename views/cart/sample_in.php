<tr class="sample_item" data-pid="<?php echo $p_id; ?>"  data-row="samples">
    <td class="product-thumbnail">
        <a href="<?php echo _A_::$app->router()->UrlTo('product',['p_id'=>$p_id,'back'=>'cart']); ?>">
            <img width="110" height="110" alt="" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
                 src="<?php echo $img_url; ?>">
        </a>
    </td>
    <td data-title="Product" class="product-name">
        <a href="<?php echo _A_::$app->router()->UrlTo('product',['p_id'=>$p_id,'back'=>'cart']); ?>"><?php echo $item['Product_name']; ?></a>
    </td>
    <td data-title="Quantity" class="product-quantity">
        <span class="quantity"><?php echo $item['quantity']; ?></span>
    </td>
    <td class="product-remove">
        <a id="del_sample_cart" href="<?php echo _A_::$app->router()->UrlTo('cart/del_sample');?>">
            <i class=" fa fa-trash-o"></i>
        </a>
    </td>
</tr>
