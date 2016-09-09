<?php if (
    (isset($cart_items) && count($cart_items) > 0) ||
    (isset($cart_samples_items) && count($cart_samples_items) > 0)
) { ?>
    <div id="div_subtotal_table">
        <table id="subtotal_table" cellspacing="0"
               class="shop_table shop_table_responsive cart">
            <tbody>
            <?php if (isset($handlingcost) && ($handlingcost > 0)) { ?>
                <tr class="subtotal">
                    <td class="product-name">Handling</td>
                    <td data-title="Handling" style="text-align:right;">
                        <span class="amount">
                            $<?php echo number_format($handlingcost, 2); ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            <?php if (isset($shipDiscount) && ($shipDiscount > 0)) { ?>
                <tr class="subtotal">
                    <td class="product-name">Shipping Discount</td>
                    <td data-title="Shipping Discount" style="text-align:right;">
                        <span class="amount">
                            $<?php echo number_format($shipDiscount, 2); ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            <?php if (isset($couponDiscount) && ($couponDiscount > 0)) { ?>
                <tr class="subtotal">
                    <td class="product-name">Coupon Redemption</td>
                    <td data-title="Coupon Discount" style="text-align:right;">
                        <span class="amount">
                            $<?php echo number_format($couponDiscount, 2); ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            <?php if (isset($taxes) && ($taxes > 0)) { ?>
                <tr class="subtotal">
                    <td class="product-name">Taxes</td>
                    <td data-title="Taxes" style="text-align:right;">
                        <span class="amount">
                            $<?php echo number_format($taxes, 2); ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            <?php if (isset($total) && ($total > 0)) { ?>
                <tr class="subtotal">
                    <td class="product-name"><b>TOTAL</b></td>
                    <td data-title="Total" style="text-align:right;">
                        <span class="amount">
                            <b>$<?php echo number_format($total, 2); ?></b>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            <?php if (isset($discount) && ($discount > 0)) { ?>
                <tr class="subtotal">
                    <td  class="product-name" style="color: red;">You Saved</td>
                    <td data-title="You Saved" style="text-align:right;">
                        <span class="amount">
                            $<?php echo number_format($discount, 2); ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <hr/>
    </div>
<?php } ?>
