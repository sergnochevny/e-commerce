<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th class="text-center">Id</th>
        <th class="text-center">Email</th>
        <th class="text-center">Name</th>
        <th class="text-center">Date Registered</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($rows as $row): ?>
    <?php
        $prms['aid'] = $row[0];
        if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    ?>
    <tr>
        <td class="text-center"><?= $row[0]?></td>
        <td class="text-center"><?= $row[1]?></td>
        <td class="text-center"><?= $row[3] . ' ' . $row[4]?></td>
        <td class="text-center"><?= date('F j Y',$row[30])?></td>
        <td>
            <div class="text-center">
                <a href="<?= _A_::$app->router()->UrlTo('users/edit',$prms)?>"><i class="fa fa-pencil"></i></a>
                <a class="text-danger" id="del_user" href="<?= _A_::$app->router()->UrlTo('users/del',$prms)?>">
                    <i class=" fa fa-trash-o"></i>
                </a>
                <a class="text-success" href="<?= _A_::$app->router()->UrlTo('orders', $prms)?>"><i class="fa fa-eye"></i></a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

