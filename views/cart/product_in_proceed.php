<!--<td data-title="Product" class="product-number">
        <span class="number"><?= $item['Product_number']; ?></span>
    </td>-->
<!--<td data-title="Price" class="product-price">
        <span class="amount"><?= $item['format_price']; ?></span>
    </td>
    <td data-title="Discount" class="product-discount">
        <span class="discount"><?= $item['format_discount'];; ?></span>
    </td>-->


<div class="row cart_item" data-pid="<?= $pid; ?>">
  <div class="col-sm-6 table-list-row-item">
    <div class="row">
      <a><?= $item['Product_name']; ?></a>
    </div>
  </div>
  <div class="col-sm-2"><?= $item['format_sale_price']; ?></div>
  <div class="col-sm-2"><?= $item['quantity']; ?></div>
  <div class="col-sm-2">
    <?= $format_subtotal; ?>
  </div>
</div>
