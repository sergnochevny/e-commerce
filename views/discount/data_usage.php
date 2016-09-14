<tr>
    <td><b><?php echo $p_discount_amount;?>% off </b><?php echo $discount_comment1;?></td>
    <td>
        <center><?php echo $enabled;?></center>
    </td>
    <td>
        <center><?php echo $allow_multiple;?></center
    </td>
    <td>
        <center><?php echo !empty($coupon_code) ? $coupon_code : 'N/A';?></center>
    </td>
    <td><?php echo $date_start;?></td>
    <td>
        <center><?php echo $date_end;?></center>
    </td>
</tr>