<?php
    $opt['discount_id'] = $row['sid'];

    $row['date_start'] = gmdate("F j, Y, g:i a", $row['date_start']);
    $row['date_end'] = gmdate("F j, Y, g:i a", $row['date_end']);
    $row['enabled'] = $row['enabled'] == "1" ? "YES" : "NO";
    $row['allow_multiple'] = $row['allow_multiple'] == "1" ? "YES" : "NO";
?>
<tr>
    <td><b><?= $row['discount_amount'];?>% off </b><?= $row['discount_comment1'];?></td>
    <td><div class="text-center"><?= $row['enabled'];?></div></td>
    <td><div class="text-center"><?= $row['allow_multiple'];?></div></td>
    <td><div class="text-center"><?= !empty($row['coupon_code']) ? $row['coupon_code'] : 'N/A'; ?></div></td>
    <td><?= $row['date_start'];?></td>
    <td><div class="text-center"><?= $row['date_end'];?></div></td>
    <td>
        <div class="text-center">
            <a rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/edit', $opt); ?>">
                <i class="fa fa-pencil"></i>
            </a>
            <a id="del_discount" rel="nofollow" href="<?= _A_::$app->router()->UrlTo('del_discounts', $opt); ?>">
                <i class=" fa fa-trash-o"></i>
            </a>
            <a class="text-success" rel="nofollow" href="<?= _A_::$app->router()->UrlTo('usage_discounts', $opt); ?>">
                <i class="fa fa-check-circle"></i>
            </a>
        </div>
    </td>
</tr>