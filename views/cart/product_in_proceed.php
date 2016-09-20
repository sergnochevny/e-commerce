<tr class="cart_item" data-pid="<?= $p_id; ?>" data-row="items">
    <td data-title="Product" class="product-name"><a><?= $item['Product_name']; ?></a></td>
    <!--<td data-title="Product" class="product-number">
        <span class="number"><?= $item['Product_number']; ?></span>
    </td>-->
    <!--<td data-title="Price" class="product-price">
        <span class="amount"><?= $item['format_price']; ?></span>
    </td>
    <td data-title="Discount" class="product-discount">
        <span class="discount"><?= $item['format_discount'];; ?></span>
    </td>-->
    <td data-title="Sale Price" class="product-price"><span class="amount"><?= $item['format_sale_price']; ?></span></td>
    <td data-title="Quantity" class="product-quantity"><div class="quantity"><span class="quantity"><?= $item['quantity']; ?></span></div></td>
    <td data-title="Total" class="product-subtotal"><span class="amount"><?= $item['format_subtotal']; ?></span></td>
</tr>
