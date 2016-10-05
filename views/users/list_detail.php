<?php
    $opt['user_id'] = $row[0];
    if ($page > 1) $opt['page'] = $page;
?>
<tr>
    <td class="text-center"><?= $row[0]?></td>
    <td class="text-center"><?= $row[1]?></td>
    <td class="text-center"><?= $row[3] . ' ' . $row[4]?></td>
    <td class="text-center"><?= $row[30]?></td>
    <td>
        <div class="text-center">
            <a href="<?= _A_::$app->router()->UrlTo('users/edit',$opt)?>"><i class="fa fa-pencil"></i></a>
            <a class="text-danger" id="del_user" href="<?= _A_::$app->router()->UrlTo('users/del',$opt)?>">
                <i class=" fa fa-trash-o"></i>
            </a>
            <a class="text-success" href="<?= _A_::$app->router()->UrlTo('orders', $opt)?>"><i class="fa fa-eye"></i></a>
        </div>
    </td>
</tr>
