<div class="col-xs-12 table-list-header hidden-xs">
  <div class="row">
    <div class="col-sm-11 col">
      Name <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
  </div>
</div>
<?php foreach($rows as $row): ?>
  <?php
  $prms = ['id' => $row[0]];
  if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
  ?>
  <div class="col-xs-12 table-list-row">
    <div class="row">
      <div class="col-xs-12 col-sm-11 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Name</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $row[1] ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
        <a class="update"
           data-modify href="<?= _A_::$app->router()->UrlTo('blogcategory/edit', $prms); ?>">
          <i class="fa fa-pencil"></i>
        </a>
        <a class="text-danger <?= $row[2] > 0 ? 'disabled' : 'delete'; ?>"
           data-delete href="<?= _A_::$app->router()->UrlTo('blogcategory/delete', $prms); ?>">
          <i class="fa fa-trash"></i>
        </a>
      </div>
    </div>
  </div>
<?php endforeach; ?>

