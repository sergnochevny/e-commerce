<?php
    $opt['category_id'] = $row[0];
?>

<?=
'<tr>
    <td><center>'. $row[1] .'</td>
    <td>'.$row[2].'</td>
    <td><div class="text-center">'.$row[3].'</div></td>
    <td><div class="text-center">'.$row[4].'</div></td>
    <td><div class="text-center">'.$row[5].'</div></td>
    <td>
        <div class="text-center">
        <figcaption>
            <a href="'._A_::$app->router()->UrlTo('edit_categories', $opt).'" class=""><i class="fa fa-pencil"></i></a>
            <a href="'._A_::$app->router()->UrlTo('del_categories', $opt).'" id="del_category" rel="nofollow" class="text-danger">
                <i class=" fa fa-trash-o"></i>
            </a>
        </figcaption>'.
        '</div>
    </td>
</tr>';
?>