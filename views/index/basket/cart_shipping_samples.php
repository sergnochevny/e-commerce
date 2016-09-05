<th>Shipping</th>
<td data-title="Shipping">
    <p>
    <table>
        <tbody>
        <?php
        if ($systemAllowExpressSamples) { ?>
            <?php
            #if the user has not selected express post, show the teaser.  if they have then dont show it
            if (!$bExpressSamples) {
                ?>
                <tr>
                    <td valign="middle" class="copyProducts">
                        Express Post... generally delivered within 5-7 days
                    </td>
                </tr>
            <?php } ?>
            <tr align="left" valign="middle">
                <td valign="middle" class="viewDetails">
                    <input id="express_samples" type="checkbox" name="express_samples"
                           value="1" <?php echo ($bExpressSamples) ? 'checked' : ''; ?>>
                    DELIVER MY SAMPLES BY OVERNIGHT COURIER<br>
                    &nbsp;<font color="#663300">$<?php echo number_format(SAMPLES_PRICE_EXPRESS_SHIPPING, 2); ?> USD
                        surcharge</font>
                    <?php if ($bExpressSamples) { ?>
                        <p style="font-size:80%;">
                            <b>NOTE: </b>
                            Only orders placed Monday through Thursday prior to 2:00 PM Eastern time will be processed
                            for overnight delivery. Orders placed outside those hours will be processed the next open
                            business day.
                        </p>
                    <?php } ?>
                </td>
            </tr>
            <?php
        }
        if ($bExpressSamples) {
            ?>

            <tr align="left" valign="middle">
                <td valign="middle" class="viewDetails" colspan="4" style="color: #000000;">
                    <input id="accept_express" type="checkbox" name="accept_express" value="1" <?php echo($bAcceptExpress)?'checked':'';?>>
                    <span style="font-size: 80%;">
                        I acknowledge that in rare cases samples may not arrive overnight due to circumstances beyond the control of iLuvFabrix.com. There are no guarantees or refunds given for this service.
                    <span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </p>
</td>

