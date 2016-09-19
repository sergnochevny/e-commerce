<?php
    $opt['discount_id'] = $row[0];

    $row[12] = gmdate("F j, Y, g:i a", $row[12]);
    $row[13] = gmdate("F j, Y, g:i a", $row[13]);
?>
<tr>
    <td><b><?= $row[2];?>% off </b><?= $row[17];?></td>
    <td><div class="text-center"><?= $row[14];?></div></td>
    <td><div class="text-center"><?= $row[11];?></div></td>
    <td><div class="text-center"><?= !empty($row[1]) ? $row[1] : 'N/A'; ?></div></td>
    <td><?= $row[12];?></td>
    <td><div class="text-center"><?= $row[13];?></div></td>
    <td>
        <div class="text-center">
            <a rel="nofollow" href="<?= _A_::$app->router()->UrlTo('edit_discounts', $opt); ?>">
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