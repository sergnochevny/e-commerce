<?php

    $prms = ['order_id' => $row[2]];
    if(_A_::$app->get('id')) $prms['id'] = _A_::$app->get('id');

?>
<tr>
    <td><div class="text-center"><?= $i ?></div></td>
    <td><div class="text-center"><?= $order_date ?></div></td>
    <td><div class="text-center"><?= $u_bill_firstname . ' ' . $u_bill_lastname ?></div></td>
    <td><div class="text-center"><?= $u_email ?></div></td>
    <td>
        <div class="text-center">
            <a href="<?= _A_::$app->router()->UrlTo('orders/discount', $prms);?>">
                <input type="submit" value="View Order" class="button">
            </a>
        </div>
    </td>
<tr>
