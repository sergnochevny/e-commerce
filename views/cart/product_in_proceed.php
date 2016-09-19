<tr class="cart_item" data-pid="<?php echo $p_id; ?>" data-row="items">
    <td data-title="Product" class="product-name">
        <a><?php echo $item['Product_name']; ?></a>
    </td>
    <!--<td data-title="Product" class="product-number">
        <span class="number"><?php echo $item['Product_number']; ?></span>
    </td>-->
    <!--<td data-title="Price" class="product-price">
        <span class="amount"><?php echo $item['format_price']; ?></span>
    </td>
    <td data-title="Discount" class="product-discount">
        <span class="discount"><?php echo $item['format_discount'];; ?></span>
    </td>-->
    <td data-title="Sale Price" class="product-price">
        <span class="amount"><?php echo $item['format_sale_price']; ?> </span>
    </td>
    <td data-title="Quantity" class="product-quantity">
        <div class="quantity">
            <span class="quantity"><?php echo $item['quantity']; ?></span>
        </div>
    </td>
    <td data-title="Total" class="product-subtotal">
        <span class="amount"><?php echo $item['format_subtotal']; ?></span>
    </td>
</tr>
