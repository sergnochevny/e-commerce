<div class="col-xs-12 table-list-header hidden-xs">
  <div class="row">
    <div class="col-sm-4 col">
      Email <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-3 col">
      Title <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-4 col">
      Date <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
  </div>
</div>

<?php foreach($rows as $row): ?>
<?php $prms['id'] = $row[0]; if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
<div class="col-xs-12 table-list-row">
  <div class="row">
    <div class="col-xs-12 col-sm-4 table-list-row-item">
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
    <div class="col-xs-12 col-sm-2 table-list-row-item">
      <div class="col-xs-4 visible-xs helper-row">
        <div class="row">Date</div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row"><?= date("m/d/Y", strtotime($row['dt'])) ?></div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-1 table-list-row-item">
      <div class="col-xs-4 visible-xs helper-row">
        <div class="row">Visibility</div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row">
          <i title="<?= $row['moderated'] == '0' ? 'Hidden' : 'Visible'; ?>" class="fa <?= $row['moderated'] == '0' ? 'fa-eye-slash' : 'fa-eye'; ?>"></i>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 text-right action-buttons">
      <a data-modify class="edit-comment"
         href="<?= _A_::$app->router()->UrlTo('comments/edit', $prms) ?>"
         title="Edit comment"><i class="fa fa-pencil"></i>
      </a>
      <a data-view class="text-success view-comment"
         href="<?= _A_::$app->router()->UrlTo('comments/comment', $prms) ?>"
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