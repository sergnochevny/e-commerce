<tr>
    <td ><?php echo $row[0]?></td>
    <td><?php echo $row[1]?></td>
    <td><?php echo $row[3] . ' ' . $row[4]?></td>
    <td><?php echo $row[30]?></td>
    <td >
        <center>
            <a href="<?php echo _A_::$app->router()->UrlTo('user/edit',['user_id'=>$row[0],'page'=>$page])?>">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="text-danger" id="del_user" href="<?php echo _A_::$app->router()->UrlTo('user/del',['user_id'=>$row[0],'page'=>$page])?>">
                <i class=" fa fa-trash-o"></i>
            </a>
            <a class="text-success" href="<?php echo _A_::$app->router()->UrlTo('orders', ['user_id'=>$row[0],'page'=>$page])?>">
                <i class="fa fa-eye"></i>
            </a>
        </center>
    </td>
</tr>
