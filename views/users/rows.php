<?php if (sizeof($rows) > 0): ?>
  <?php
  if (!is_null(_A_::$app->get('page'))) $order['page'] = _A_::$app->get('page');
  ?>
  <div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
      <div class="col-sm-1 col">
        <?php
          if (isset($sort['aid'])) {
            $order['sort'] = 'aid';
            $order['order'] = ($sort['aid'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'aid';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Id
          <small>
            <i class="fa <?= ($order['order'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
          </small>
        </a>
      </div>
      <div class="col-sm-4 col text-center">
        <?php
          if (isset($sort['email'])) {
            $order['sort'] = 'email';
            $order['order'] = ($sort['email'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'email';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Email
          <small>
            <i class="fa <?= ($order['order'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
          </small>
        </a>
      </div>
      <div class="col-sm-3 col text-center">
        <?php
          if (isset($sort['name'])) {
            $order['sort'] = 'name';
            $order['order'] = ($sort['name'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'name';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Name
          <small>
            <i class="fa <?= ($order['order'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
          </small>
        </a>
      </div>
      <div class="col-sm-2 col text-center">
        <?php
          if (isset($sort['date_registered'])) {
            $order['sort'] = 'date_registered';
            $order['order'] = ($sort['aid'] == 'date_registered' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'date_registered';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Registered
          <small>
            <i class="fa <?= ($order['order'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
          </small>
        </a>
      </div>
    </div>
  </div>
  <?php foreach ($rows as $row): ?><?php $prms['aid'] = $row[0];
    if (!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
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
          <div class="col-xs-8 col-sm-12 text-center xs-text-left">
            <div class="row"><?= $row[1] ?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-3 table-list-row-item">
          <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Name</div>
          </div>
          <div class="col-xs-8 col-sm-12 text-center xs-text-left">
            <div class="row"><?= $row[3] . ' ' . $row[4] ?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-2 table-list-row-item">
          <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Date Registered</div>
          </div>
          <div class="col-xs-8 col-sm-12 text-center xs-text-left">
            <div class="row"><?= date("m/j/y", $row[30]) ?></div>
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
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top">No results found</h2>
  </div>
<?php endif; ?>

