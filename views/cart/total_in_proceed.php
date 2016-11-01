<?php if((isset($cart_items) && count($cart_items) > 0) || (isset($cart_samples_items) && count($cart_samples_items) > 0)) { ?>
  <div data-block="div_subtotal_table">
    <table data-block="subtotal_table" cellspacing="0"
           class="shop_table shop_table_responsive cart">
      <tbody>
      <?php if(isset($handlingcost) && ($handlingcost > 0)) { ?>
        <tr class="subtotal">
          <td class="product-name">Handling</td>
          <td data-title="Handling" style="text-align:right;">
            <span class="amount">
              $<?= number_format($handlingcost, 2); ?>
            </span>
          </td>
        </tr>
      <?php } ?>
      <?php if(isset($shipDiscount) && ($shipDiscount > 0)) { ?>
        <tr class="subtotal">
          <td class="product-name">Shipping Discount</td>
          <td data-title="Shipping Discount" style="text-align:right;">
            <span class="amount">
              $<?= number_format($shipDiscount, 2); ?>
            </span>
          </td>
        </tr>
      <?php } ?>
      <?php if(isset($couponDiscount) && ($couponDiscount > 0)) { ?>
        <tr class="subtotal">
          <td class="product-name">Coupon Redemption</td>
          <td data-title="Coupon Discount" style="text-align:right;">
            <span class="amount">
              $<?= number_format($couponDiscount, 2); ?>
            </span>
          </td>
        </tr>
      <?php } ?>
      <?php if(isset($taxes) && ($taxes > 0)) { ?>
        <tr class="subtotal">
          <td class="product-name">Taxes</td>
          <td data-title="Taxes" style="text-align:right;">
            <span class="amount">
              $<?= number_format($taxes, 2); ?>
            </span>
          </td>
        </tr>
      <?php } ?>
      <?php if(isset($total) && ($total > 0)) { ?>
        <tr class="subtotal">
          <td class="product-name"><b>TOTAL</b></td>
          <td data-title="Total" style="text-align:right;">
            <span class="amount">
              <b>$<?= number_format($total, 2); ?></b>
            </span>
          </td>
        </tr>
      <?php } ?>
      <?php if(isset($discount) && ($discount > 0)) { ?>
        <tr class="subtotal">
          <td colspan="2">
            <hr>
          </td>
        </tr>
        <tr class="subtotal">
          <td class="product-name" style="color: red;"><b>You Saved</b></td>
          <td data-title="You Saved" style="text-align:right;">
            <span class="amount">
              $<?= number_format($discount, 2); ?>
            </span>
          </td>
        </tr>
      <?php } ?>
      <tr class="subtotal">
        <td colspan="2">
          <hr>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
<?php } ?>
