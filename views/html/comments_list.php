<?php
    $opt['id'] = $row['id'];
    $opt['page'] = $page;
?>
<div class="col-xs-12 table-list-row">
    <div class="row">
        <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs helper-row">
                <div class="row">Email</div>
            </div>
            <div class="col-xs-8 col-sm-12">
                <div class="row"><?= $row['email']; ?></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs helper-row">
                <div class="row">Title</div>
            </div>
            <div class="col-xs-8 col-sm-12">
                <div class="row"><?= $row['title'] ?></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs helper-row">
                <div class="row">Date</div>
            </div>
            <div class="col-xs-8 col-sm-12">
                <div class="row"><?= $row['dt'] ?></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-2 table-list-row-item">
            <a <?= $row['moderated'] == '0' ? "class=\"text-danger public_comment\"" : "class=\"text-success public_comment\"" ?>
              href="<?= _A_::$app->router()->UrlTo('comments/public', $opt) ?>"
              title="<?= $row['moderated'] == '1' ? 'Hide comment' : 'Show comment' ?>"
              data-value="<?= $row['moderated'] ?>">
                <?= $row['moderated'] == '1' ? "Displaying" : "Hiden" ?>
                <i class="fa <?= $row['moderated'] == '0' ? 'fa-minus-square-o' : 'fa-check-square-o'; ?>"></i>
            </a>
        </div>
        <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
            <a data-edit class="edit-comment"
               href="<?= _A_::$app->router()->UrlTo('comments/edit', $opt) ?>"
               title="Edit comment"><i class="fa fa-pencil"></i>
            </a>
            <a data-view class="text-success view-comment"
               href="<?= _A_::$app->router()->UrlTo('comments/comment', $opt) ?>"
               title="View comment"><i class="fa fa-eye"></i>
            </a>

            <a data-delete class="text-danger del_user"
               href="<?= _A_::$app->router()->UrlTo('comments/delete', $opt); ?>"
               title="Delete comment"><i class=" fa fa-trash-o"></i>
            </a>
        </div>
    </div>
</div>

<tr>

    <td>
        <div class="text-center">

        </div>
    </td>
</tr>
