<?php

    $opt['o_id'] = $row[0];
    $opt['user_id'] = $user_id;
    $opt['page'] = $page;

?>
<tr>
    <td class="text-left"><b><?= $row[0] ?></b></td>
    <td class="text-center"><b><?= $row[22] ?></b></td>
    <td class="text-center"><b>ground ship</b></td>
    <td class="text-center"><b><?= $row[12] ?></b></td>
    <td class="text-center"><b><?= $row[14] ?></b></td>
    <td class="text-center">
        <a class="text-success" href="<?= _A_::$app->router()->UrlTo('orders/info', $opt) ?>"><i class="fa fa-eye"></i></a>
    </td>
</tr>
