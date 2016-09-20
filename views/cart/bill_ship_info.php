<div class="proceed_bill">
    <table cellspacing="0" class="shop_table shop_table_responsive proceed">
        <thead><tr><th>Bill To:</th></tr></thead>
        <tbody>
            <?php if (isset($bill_firstname) && strlen($bill_firstname) > 0) {?><tr><td><?= $bill_firstname; ?></td></tr><?php } ?>
            <?php if (isset($bill_lastname) && strlen($bill_lastname) > 0) {?><tr><td><?= $bill_lastname; ?></td></tr><?php } ?>
            <?php if (isset($bill_organization) && strlen($bill_organization) > 0) {?><tr><td><?= $bill_organization; ?></td></tr><?php } ?>
            <?php if (isset($bill_address1) && strlen($bill_address1) > 0) {?><tr><td><?= $bill_address1; ?></td></tr><?php } ?>
            <?php if (isset($bill_address2) && strlen($bill_address2) > 0) {?><tr><td><?= $bill_address2; ?></td></tr><?php } ?>
            <?php if (isset($bill_city) && strlen($bill_city) > 0) {?><tr><td><?= $bill_city; ?></td></tr><?php } ?>
            <?php if (isset($bill_province) && strlen($bill_province) > 0) {?><tr><td><?= $bill_province; ?></td></tr><?php } ?>
            <?php if (isset($bill_postal) && strlen($bill_postal) > 0) {?><tr><td><?= $bill_postal; ?></td></tr><?php } ?>
            <?php if (isset($bill_country) && strlen($bill_country) > 0) {?><tr><td><?= $bill_country; ?></td></tr><?php } ?>
            <?php if (isset($bill_phone) && strlen($bill_phone) > 0) {?><tr><td><?= $bill_phone; ?></td></tr><?php } ?>
        </tbody>
    </table>
</div>
<div class="proceed_ship">
    <table cellspacing="0" class="shop_table shop_table_responsive proceed">
        <thead><tr><th>Ship To:</th></tr></thead>
        <tbody>
            <?php if (isset($ship_firstname) && strlen($ship_firstname) > 0) {?> <tr><td><?= $ship_firstname; ?></td></tr><?php } ?>
            <?php if (isset($ship_lastname) && strlen($ship_lastname) > 0) {?> <tr><td><?= $ship_lastname; ?></td></tr><?php } ?>
            <?php if (isset($ship_organization) && strlen($ship_organization) > 0) {?> <tr><td><?= $ship_organization; ?></td></tr><?php } ?>
            <?php if (isset($ship_address1) && strlen($ship_address1) > 0) {?> <tr><td><?= $ship_address1; ?></td></tr><?php } ?>
            <?php if (isset($ship_address2) && strlen($ship_address2) > 0) {?> <tr><td><?= $ship_address2; ?></td></tr><?php } ?>
            <?php if (isset($ship_city) && strlen($ship_city) > 0) {?> <tr><td><?= $ship_city; ?></td></tr><?php } ?>
            <?php if (isset($ship_province) && strlen($ship_province) > 0) {?> <tr><td><?= $ship_province; ?></td></tr><?php } ?>
            <?php if (isset($ship_postal) && strlen($ship_postal) > 0) {?> <tr><td><?= $ship_postal; ?></td></tr><?php } ?>
            <?php if (isset($ship_country) && strlen($ship_country) > 0) {?> <tr><td><?= $ship_country; ?></td></tr><?php } ?>
            <?php if (isset($ship_phone) && strlen($ship_phone) > 0) {?> <tr><td><?= $ship_phone; ?></td></tr><?php } ?>
        </tbody>
    </table>
</div>
