<tr>
    <td ><?php echo $row[0]?></td>
    <td><?php echo $row[1]?></td>
    <td><?php echo $row[3] . ' ' . $row[4]?></td>
    <td><?php echo $row[30]?></td>
    <td >
        <center>
            <a href="<?php echo $base_url?>/edit_user?user_id=<?php echo $row[0]?>&page=<?php echo $page?>">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="text-danger" id="del_user" href="<?php echo $base_url?>/del_user?id=<?php echo $row[0]?>&page=<?php echo $page?>">
                <i class=" fa fa-trash-o"></i>
            </a>
            <a class="text-success" href="<?php echo $base_url?>/orders?user_id=<?php echo $row[0]?>&page=<?php echo $page?>">
                <i class="fa fa-eye"></i>
            </a>
        </center>
    </td>
</tr>
