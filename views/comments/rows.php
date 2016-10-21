<?php if (sizeof($rows) > 0): ?>
    <div class="col-xs-12 table-list-header hidden-xs">
        <div class="row">
            <div class="col-sm-3 col">
                Email <a href="#">
                    <small><i class="fa fa-chevron-down"></i></small>
                </a>
            </div>
            <div class="col-sm-3 col text-center">
                Title <a href="#">
                    <small><i class="fa fa-chevron-down"></i></small>
                </a>
            </div>
            <div class="col-sm-2 col text-center">
                Date <a href="#">
                    <small><i class="fa fa-chevron-down"></i></small>
                </a>
            </div>
        </div>
    </div>

    <?php foreach ($rows as $row): ?>
        <?php
        $prms['id'] = (int)$row['id'];
        $prms['action'] = $row['moderated'] == '1' ? '0' : '1';
        if (!is_null(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }
        ?>
        <div class="col-xs-12 table-list-row">
            <div class="row">
                <div class="col-xs-12 col-sm-3 table-list-row-item">
                    <div class="col-xs-4 visible-xs helper-row">
                        <div class="row">Email</div>
                    </div>
                    <div class="col-xs-8 col-sm-12">
                        <div class="row cut-text-in-one-line"><?= $row['email']; ?></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 table-list-row-item">
                    <div class="col-xs-4 visible-xs helper-row">
                        <div class="row">Title</div>
                    </div>
                    <div class="col-xs-8 col-sm-12 text-center xs-text-left">
                        <div class="row"><?= $row['title'] ?></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 table-list-row-item">
                    <div class="col-xs-4 visible-xs helper-row">
                        <div class="row">Date</div>
                    </div>
                    <div class="col-xs-8 col-sm-12 text-center xs-text-left">
                        <div class="row"><?= date("m/d/Y", strtotime($row['dt'])) ?></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 table-list-row-item">
                    <div class="col-xs-4 visible-xs helper-row">
                        <div class="row">Visibility</div>
                    </div>
                    <div class="col-xs-8 col-sm-12 text-center xs-text-left">
                        <div class="row">
                            <a class="comment-moderated-action <?= $row['moderated'] == '0' ? '' : 'text-danger'; ?>"
                               data-status="<?= $row['moderated'] == '1' ? '0' : '1' ?>"
                               data-id="<?= $row['id'] ?>"
                               href="<?= _A_::$app->router()->UrlTo('comments/moderate', $prms) ?>">
                                <?= $row['moderated'] == '0' ? 'Hide' : 'Publish'; ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-1 text-right action-buttons">
                    <a data-modify
                       href="<?= _A_::$app->router()->UrlTo('comments/edit', $prms) ?>"
                       title="Edit comment"><i class="fa fa-pencil"></i>
                    </a>
                    <a data-view class="text-success view-comment"
                       href="<?= _A_::$app->router()->UrlTo('comments/view', $prms) ?>"
                       title="View comment"><i class="fa fa-eye"></i>
                    </a>
                    <a data-delete class="text-danger del_user"
                       href="<?= _A_::$app->router()->UrlTo('comments/delete', $prms); ?>"
                       title="Delete comment"><i class=" fa fa-trash-o"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="col-sm-12 text-center offset-top">
        <h2 class="offset-top">No results found</h2>
    </div>
<?php endif; ?>
