<?php if(sizeof($rows) > 0): ?>
  <div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
      <div class="col-sm-8 col">
        <?php
          if (isset($sort['cname'])) {
            $order['sort'] = 'cname';
            $order['order'] = ($sort['cname'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'cname';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('categories', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Name
          <small><i class="fa <?= ($order['order'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i></small>
        </a>
      </div>
      <div class="col-sm-3 col">
        <?php
          if (isset($sort['displayorder'])) {
            $order['sort'] = 'displayorder';
            $order['order'] = ($sort['displayorder'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'displayorder';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('categories', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Display Order
          <small><i class="fa <?= ($order['order'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i></small>
        </a>
      </div>
    </div>
  </div>
  <?php foreach($rows as $row): ?>
    <?php $prms['cid'] = $row[0]; if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
    <div class="col-xs-12 table-list-row">
      <div class="row">
        <div class="col-xs-12 col-sm-8 table-list-row-item">
            <div class="col-xs-4 visible-xs helper-row">
              <div class="row">Name</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row[1] ?></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs helper-row">
              <div class="row">Display Order</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row[2] ?></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
          <a data-modify href="<?= _A_::$app->router()->UrlTo('categories/edit', $prms) ?>">
            <i class="fa fa-pencil"></i>
          </a>
          <a href="<?= _A_::$app->router()->UrlTo('categories/delete', $prms) ?>" data-delete rel="nofollow"
             class="text-danger <?= ($row[2]>0)?'disabled':''?>">
            <i class=" fa fa-trash-o"></i>
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

