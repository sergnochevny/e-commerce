<?php

    $opt['order_id'] = $row[0];
    $opt['user_id'] = $user_id;
    $opt['page'] = $page;

?>
<tr>
    <td><div class="text-center"><b><?= $row[0] ?></b></div></td>
    <td><div class="text-center"><b><?= $row[22] ?></b></div></td>
    <td><div class="text-center"><b>ground ship</b></div></td>
    <td><div class="text-center"><b><?= $row[12] ?></b></div></td>
    <td><div class="text-center"><b><?= $row[14] ?></b></div></td>
    <td>
        <div class="text-center">
            <a class="text-success" href="<?= _A_::$app->router()->UrlTo('order', $opt) ?>"><i class="fa fa-eye"></i></a>
        </div>
    </td>
</tr>
