<div class="col-xs-12 table-list-header hidden-xs">
  <div class="row">
    <div class="col-sm-1 col">
      Id <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-4 col">
      Email
    </div>
    <div class="col-sm-3 col">
      Name
    </div>
    <div class="col-sm-2 col">
      Date Registered <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
  </div>
</div>
<?php foreach($rows as $row): ?> <?php $prms['aid'] = $row[0]; if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
  <div class="col-xs-12 table-list-row">
    <div class="row">
      <div class="col-xs-12 col-sm-1 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Id</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row cut-text-in-one-line"><?= $row[0]; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Email</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $row[1] ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-3 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Name</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $row[3] . ' ' . $row[4] ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Date Registered</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= date('F j Y', $row[30]) ?></div>
        </div>
      </div>

      <div class="col-xs-12 col-sm-2 text-right action-buttons">
        <a data-modify href="<?= _A_::$app->router()->UrlTo('users/edit', $prms) ?>">
          <i class="fa fa-pencil"></i>
        </a>
        <a data-delete class="text-danger" href="<?= _A_::$app->router()->UrlTo('users/delete', $prms) ?>">
          <i class=" fa fa-trash-o"></i>
        </a>
        <a class="text-success" href="<?= _A_::$app->router()->UrlTo('orders', $prms) ?>"><i
            class="fa fa-eye"></i></a>
      </div>
    </div>
  </div>
<?php endforeach; ?>