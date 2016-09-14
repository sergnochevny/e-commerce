<tr>
    <td>
        <center><?php echo $i ?></center>
    </td>
    <td>
        <center><?php echo $order_date ?></center>
    </td>
    <td>
        <center><?php echo $u_bill_firstname . ' ' . $u_bill_lastname ?></center>
    </td>
    <td>
        <center><?php echo $u_email ?></center>
    </td>
    <td>
        <center>
            <a href="
            <?php
            $prms = ['order_id' => $row[2]];
            if(_A_::$app->get('id')) $prms['id'] = _A_::$app->get('id');
                echo _A_::$app->router()->UrlTo('orders/discount', $prms);?>">
                <input type="submit" value="View Order" class="button">
            </a>
        </center>
    </td>
<tr>
