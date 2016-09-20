<?php
    $opt['id'] = $row['id'];
    $opt['page'] = $page;
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['dt'] ?></td>
    <td>
        <div class="text-center">
            <a id="edit-comment"
               href="<?= _A_::$app->router()->UrlTo('comments/edit', $opt) ?>"
               title="Edit comment"><i class="fa fa-pencil"></i>
            </a>
            <a class="text-success" id="view-comment"
               href="<?= _A_::$app->router()->UrlTo('comments/view', $opt) ?>"
               title="View comment"><i class="fa fa-eye"></i>
            </a>

            <a class="text-danger" id="del_user"
               href="<?= _A_::$app->router()->UrlTo('comments/delete', $opt); ?>"
               title="Delete comment"><i class=" fa fa-trash-o"></i>
            </a>
        </div>
    </td>
    <td>
        <a <?= $row['moderated'] == '0' ? "class=\"text-danger\"" : "class=\"text-success\"" ?>
            id="public_comment"
            href="<?= _A_::$app->router()->UrlTo('comments/public', $opt) ?>"
            title="<?= $row['moderated'] == '1' ? 'Hide comment' : 'Show comment' ?>"
            data-value="<?= $row['moderated'] ?>">
            <?= $row['moderated'] == '1' ? "Yes" : "No" ?>
            <i class="fa <?= $row['moderated'] == '0' ? 'fa-minus-square-o' : 'fa-check-square-o'; ?>"></i>
        </a>
    </td>
</tr>
