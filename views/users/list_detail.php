<tr>
    <td >= $row[0]?></td>
    <td>= $row[1]?></td>
    <td>= $row[3] . ' ' . $row[4]?></td>
    <td>= $row[30]?></td>
    <td >
        <center>
            <a href="= _A_::$app->router()->UrlTo('users/edit',['user_id'=>$row[0],'page'=>$page])?>">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="text-danger" id="del_user" href="= _A_::$app->router()->UrlTo('users/del',['user_id'=>$row[0],'page'=>$page])?>">
                <i class=" fa fa-trash-o"></i>
            </a>
            <a class="text-success" href="= _A_::$app->router()->UrlTo('orders', ['user_id'=>$row[0],'page'=>$page])?>">
                <i class="fa fa-eye"></i>
            </a>
        </center>
    </td>
</tr>
