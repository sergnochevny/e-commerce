<tr>
    <td><span class="cut-text-in-one-line"><b><?= $p_discount_amount;?>% off </b><?= $discount_comment1;?></span></td>
    <td>
        <div class="text-center"><?= $order_date;?></div>
    </td>
    <td>
        <div class="text-center"><?= $allow_multiple;?></div>
    </td>
    <td>
        <div class="text-center"><?= !empty($coupon_code) ? $coupon_code : 'N/A';?></div>
    </td>
    <td class="text-center"><?= $date_start;?></td>
    <td>
        <div class="text-center"><?= $date_end;?></div>
    </td>
</tr>