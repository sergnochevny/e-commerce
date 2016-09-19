<tr>
    <td><b><?= $p_discount_amount;?>% off </b><?= $discount_comment1;?></td>
    <td>
        <div class="text-center"><?= $enabled;?></div>
    </td>
    <td>
        <div class="text-center"><?= $allow_multiple;?></div>
    </td>
    <td>
        <div class="text-center"><?= !empty($coupon_code) ? $coupon_code : 'N/A';?></div>
    </td>
    <td><?= $date_start;?></td>
    <td>
        <div class="text-center"><?= $date_end;?></div>
    </td>
</tr>