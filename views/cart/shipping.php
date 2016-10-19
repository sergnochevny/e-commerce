<th>Shipping</th>
<td data-title="Shipping">
    <label for="select_ship">Method: </label>
    <select id="select_ship"  size="1" name="ship">
        <option value="0">select shipping method</option>
        <option <?= ($shipping == 1) ? 'selected' : '' ?> value="1">express post</option>
        <option <?= ($shipping == 3) ? 'selected' : '' ?> value="3">ground ship</option>
    </select>

    <p>
    <table class="table table-bordered table-condensed tableNoResp">
        <tbody>
            <?php if (count($cart_items) > 0) { ?>
                <tr>
                    <td>
                        <input id="roll" type="checkbox" name="roll" value="1" <?= $bShipRoll ? 'checked' : ''; ?>>
                        <label for="roll">Ship my fabric on a roll.</label>
                    </td>
                    <td>
                        <p style="font-size:80%; margin: 0;"><b>NOTE: </b>
                            This cost $<?= number_format(RATE_ROLL, 2); ?> USD
                        </p>
                    </td>
                </tr>
            <?php } ?>
        <tr>
            <td>SHIPPING</td>
            <td><b><span style="color: #663300">$<?= number_format($shipcost, 2); ?> USD</span></b><br/></td>
        </tr>
        <?php if (count($cart_items) > 0) { ?>
            <tr>
                <td>HANDLING</td>
                <td><b><span style="color: #663300">$<?= number_format(RATE_HANDLING, 2); ?> USD</span></b><br/></td>
            </tr>
        <?php } ?>
        <?php if ($shipDiscount > 0) { ?>
            <tr>
                <td>SHIPPING DISCOUNT</td>
                <td><b><span color="#663300">$<?= number_format($shipDiscount, 2); ?> USD</span></b></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </p>

    <p style="font-size:80%;"><b>NOTE: </b>
        <?php
            if ($shipping == 1) {
                echo "Delivery can be generally expected within 5 days from the shipping date of the order (orders usually ship within 48 hours of payment).  Please note that this is an approximation as it relies on the mail, a service over which we have no control.";
            } else {
                echo "Delivery can be generally expected within 2 weeks from the shipping date of the order (orders usually ship within 48 hours of payment).  Please note that this is an approximation as it relies on the mail, a service over which we have no control.";
            }
        ?>
    </p>


    <!--<form method="post" action="#"
          class="woocommerce-shipping-calculator">-->

    <section style="display:none;" class="shipping-calculator-form">

        <p id="calc_shipping_country_field"
           class="form-row form-row-wide">
            <select rel="calc_shipping_state"
                    class="country_to_state"
                    id="calc_shipping_country"
                    name="calc_shipping_country">
                <option value="">Select a country…</option>
                <option value="CA">Canada</option>
                <option value="US">United States (US)</option>
            </select>
        </p>

        <p id="calc_shipping_state_field"
           class="form-row form-row-wide">
            <input type="text" id="calc_shipping_state"
                   name="calc_shipping_state"
                   placeholder="State / county" value=""
                   class="input-text"></p>


        <p id="calc_shipping_postcode_field"
           class="form-row form-row-wide">
            <input type="text" id="calc_shipping_postcode"
                   name="calc_shipping_postcode"
                   placeholder="Postcode / ZIP" value=""
                   class="input-text">
        </p>


    </section>
    <!--</form>-->

</td>
