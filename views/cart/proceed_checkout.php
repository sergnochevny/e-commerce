<a href="<?= $back_url; ?>" class="back_button"><input type="button" value="Back" class="button"></a>

<div class="row">
    <div class="col-md-12">

        <article class="page type-page status-publish entry" style="overflow:hidden;">
            <br/>
            <div class="entry-content">
                <div class="woocommerce">
                    <div class="proceed_title">
                        <span>PLEASE REVIEW AND CONFIRM ORDER</span>
                    </div>
                    <!--<form method="post">-->
                    <table cellspacing="0" class="shop_table shop_table_responsive proceed">
                        <thead>
                        <tr>
                            <th class="product-name">Product</th>
                            <!--<th class="product-price">Price</th>
                            <th class="product-subtotal">Discount</th>-->
                            <th class="product-price">Sale Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-subtotal">SubTotal</th>
                        </tr>
                        </thead>
                        <tbody data-block="product_in_cart">

                        <?php

                        echo isset($cart_items) ? $cart_items : '';//products
                        echo isset($cart_samples_items) ? $cart_samples_items : '';//samples
                        if (isset($cart_samples_items) && strlen($cart_samples_items) > 0) {
                            ?>
                            <tr class="sample_item" data-row="samples">
                                <td data-title="Product" class="product-name" colspan="1" style="text-align: right">
                                    <a>Samples cost</a>
                                </td>
                                <td data-title="Price" class="product-price">
                                    <?= isset($sum_samples) ? $sum_samples : ''; ?>
                                </td>
                                <td></td>
                                <td data-title="Subtotal" class="product-subtotal">
                                    <span class="amount"><?= isset($sum_samples) ? $sum_samples : ''; ?></span>
                                </td>
                            </tr>
                        <?php } ?>

                        <?= isset($shipping) ? $shipping : ''; ?>
                        </tbody>
                    </table>
                    <!--</form>-->

                    <div class="collaterals">

                        <div class="proceed_totals">
                            <?php if (
                                (isset($cart_items) && strlen($cart_items) > 0) ||
                                (isset($cart_samples_items) && strlen($cart_samples_items) > 0)
                            ) { ?>
                                <?= isset($total_proceed) ? $total_proceed : ''; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>
<div class="row row_bill_ship">
    <div class="col-md-12">

        <article class="page type-page status-publish entry" style="overflow:hidden;">
            <div class="row" style="margin: 0;">
                <div class="woocommerce">
                    <div class="proceed_title">
                        <span>PLEASE REVIEW AND CONFIRM YOUR DETAILS</span>
                    </div>
                    <div data-block="proceed_bill_ship" class="collaterals">
                        <?= isset($bill_ship_info) ? $bill_ship_info : '' ?>
                    </div>
                </div>
            </div>
            <div class="wc-change_user_data">
                <a data-block="change_user_data" class="checkout-button button alt wc-forward"
                   href="<?= $change_user_url; ?>">
                    Edit Billing or Shipping
                </a>
            </div>
        </article>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="wc-proceed-to-checkout">
            <?php if (
                (isset($cart_items) && strlen($cart_items) > 0) ||
                (isset($cart_samples_items) && strlen($cart_samples_items) > 0)
            ) { ?>

                <a data-block="proceed_agreem_button" class="checkout-button button alt wc-forward"
                   href="<?= _A_::$app->router()->UrlTo('cart/proceed_agreem') ?>">
                    Proceed to Agreement</a>
            <?php } ?>
        </div>
    </div>
</div>




