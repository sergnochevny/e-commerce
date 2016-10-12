<div class="col-sm-12">
  <div class="col-xs-12 headline-tab">
    <div class="row">
      <div class="col-xs-7 col-sm-6 xs-text-center">
        <b>Category name</b>
      </div>
      <div class="col-xs-5 col-sm-4 xs-text-center">
        <b>Display order</b>
      </div>
    </div>
  </div>
</div>
<?php foreach($rows as $row): $prms['cid'] = $row[0]; if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
  <div class="col-sm-12">
    <div class="col-xs-12 data-list-view-item-container">
      <div class="row">
        <div class="col-xs-7 col-sm-6 xs-text-center">
<!--          <small class="data-hint">Category name</small>-->
          <div class="cut-text-in-one-line"><?= $row[1] ?></div>
        </div>
        <div class="col-xs-5 col-sm-4 xs-text-center">
<!--          <small class="data-hint">Display order</small>-->
          <div class="cut-text-in-one-line"><?= $row[2] ?></div>
        </div>
        <div class="col-xs-12 col-sm-2 xs-text-center xs-buttons-container buttons-container text-right">
          <a data-modify href="<?= _A_::$app->router()->UrlTo('categories/edit', $prms) ?>">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="<?= _A_::$app->router()->UrlTo('categories/delete', $prms) ?>" data-delete rel="nofollow"
             class="text-danger <?= ($row[2] > 0) ? 'disabled' : '' ?>">
            <i class=" fa fa-trash-o"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>