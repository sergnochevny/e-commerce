<?php if((count($cart_items) > 0) && isset($shipping) && ($shipping > 0)) { ?>
  <tr class="ship_item" data-row="ship">
    <td data-title="Shipping" class="product-name" colspan="1" style="text-align: right;">
      <a>
        <?= ($shipping == 1) ? 'Express Post' : '' ?>
        <?= ($shipping == 3) ? 'Ground Ship' : '' ?>
      </a>
    </td>
    <td data-title="Price" class="product-price" style="width: 150px;">
      <span class="amount">$<?= number_format($shipcost, 2); ?> </span>
    </td>
    <td data-title="Quantity" class="product-quantity">
      <div class="quantity">
        <span class="quantity">N/A</span>
      </div>
    </td>
    <td data-title="Total" class="product-subtotal">
      <span class="amount">$<?= number_format($shipcost, 2); ?></span>
    </td>
  </tr>
<?php } ?>
<?php if((count($cart_items) > 0) && isset($bShipRoll) && $bShipRoll) { ?>
  <tr class="ship_item" data-row="ship">
    <td data-title="Shipping" class="product-name" colspan="1" style="text-align: right;">
      <a>
        Ship fabric on a roll
      </a>
    </td>
    <td data-title="Price" class="product-price" style="width: 150px;">
      <span class="amount">$<?= number_format($rollcost, 2); ?> </span>
    </td>
    <td data-title="Quantity" class="product-quantity">
      <div class="quantity">
        <span class="quantity">N/A</span>
      </div>
    </td>
    <td data-title="Total" class="product-subtotal">
      <span class="amount">$<?= number_format($rollcost, 2); ?></span>
    </td>
  </tr>
<?php } ?>
<?php if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) { ?>
  <tr class="ship_item" data-row="ship">
    <td data-title="Shipping" class="product-name" colspan="1" style="text-align: right;">
      <a>
        Deliver by overnight courier
      </a>
    </td>
    <td data-title="Price" class="product-price" style="width: 150px;">
      <span class="amount">$<?= number_format($express_samples_cost, 2); ?> </span>
    </td>
    <td data-title="Quantity" class="product-quantity">
      <div class="quantity">
        <span class="quantity">N/A</span>
      </div>
    </td>
    <td data-title="Total" class="product-subtotal">
      <span class="amount">$<?= number_format($express_samples_cost, 2); ?></span>
    </td>
  </tr>
<?php } ?>
<tr class="ship_item" data-row="ship">
  <td data-title="SubTotal" colspan="3" style="text-align: right;">
    <b>
      Sub Total:
    </b>
  </td>
  <td data-title="Total" class="product-subtotal">
    <b class="amount">$<?= number_format($total, 2); ?></b>
  </td>
</tr>
