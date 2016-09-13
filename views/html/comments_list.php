<tr>
    <td><?= $row['id']?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['title']?></td>
    <td><?= $row['dt']?></td>
    <td >
        <center>
            <a id="edit-comment" href="<?php echo _A_::$app->router()->UrlTo('mnf')?>/comment_edit?ID=<?php echo $row['id']?>&page=<?php echo $page?>" title="Edit comment">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="text-success" id="view-comment" href="<?php echo _A_::$app->router()->UrlTo('mnf')?>/view_comment?ID=<?php echo $row['id']?>&page=<?php echo $page?>" title="View comment">
                <i class="fa fa-eye"></i>
            </a>

            <a class="text-danger" id="del_user" href="<?php echo _A_::$app->router()->UrlTo('mnf')?>/comment_delete?ID=<?php echo $row['id']?>&page=<?php echo $page?>" title="Delete comment">
                <i class=" fa fa-trash-o"></i>
            </a>
        </center>
    </td>
    <td>
        <a <?= $row['moderated'] == '0' ? "class=\"text-danger\"" : "class=\"text-success\"" ?> id="public_comment" href="<?php echo _A_::$app->router()->UrlTo('mnf')?>/public_comment?ID=<?php echo $row['id']?>&page=<?php echo $page?>" title="<?= $row['moderated'] == '1' ? 'Hide comment' : 'Show comment' ?>" value="<?= $row['moderated'] ?>">
            <?= $row['moderated'] == '1' ? "Yes" : "No" ?>
            <i class="fa <?= $row['moderated'] == '0' ? 'fa-minus-square-o':'fa-check-square-o';?>" ></i>
        </a>
    </td>
</tr>
