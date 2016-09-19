<table border="0" cellpadding="0" cellspacing="0" style="margin: 0;">
    <tr>
        <td class="copyProducts"><br/><strong>SAMPLES DETAILS &
                COST</strong></td>
    </tr>
    <tr>
        <td class="copyProducts">

            Samples are sent through the Post Office and are usually
            delivered within 5&dash;7 days. Samples will be sent the next
            business day after order confirmation.
            <br/><br/>
            You may order Next Day courier for an additional charge.
            <table class="table table-bordered table-condensed">
                <tr>
                    <td class="copyProducts">1) Sample 1:</td>
                    <td class="copyProducts">= '$' . number_format(SAMPLES_PRICE_SINGLE, 2); ?></td>
                </tr>
                <tr>
                    <td class="copyProducts">2) Samples 2 - 5:</td>
                    <td class="copyProducts">= '$' . number_format(SAMPLES_PRICE_MULTIPLE, 2); ?></td>
                </tr>
                <tr>
                    <td class="copyProducts">3) Samples 6 & over:</td>
                    <td class="copyProducts">= '$' . number_format(SAMPLES_PRICE_ADDITIONAL, 2); ?>
                        / sample
                    </td>
                </tr>
                <?php if(!(isset($cart_items) && strlen($cart_items) > 0)){?>
                    <tr>
                        <td class="copyProducts">4) Courier delivery
                            surcharge:
                        </td>
                        <td class="copyProducts">= '$' . number_format(SAMPLES_PRICE_EXPRESS_SHIPPING, 2); ?></td>
                    </tr>
                <?php }?>
            </table>
            <br/>

        </td>
    </tr>
</table>
