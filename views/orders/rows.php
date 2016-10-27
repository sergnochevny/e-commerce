<?php if (sizeof($rows) > 0): ?>
  <div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
      <div class="col-sm-3 col">
        <?php
          if (isset($sort['o.trid'])) {
            $order['sort'] = 'o.trid';
            $order['order'] = ($sort['o.trid'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'trid';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('orders', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Order
          <?php if(isset($sort['o.trid'])) : ?>
            <small>
              <i class="fa <?= ($sort['o.trid'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
      <?php if (Controller_Admin::is_logged()): ?>
        <?php
          if (isset($sort['username'])) {
            $order['sort'] = 'username';
            $order['order'] = ($sort['username'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'username';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('orders', $order);
        ?>
        <div class="col-sm-2 col text-center">
          <a data-sort href="<?= $sort_url ?>">
            Customer
            <?php if(isset($sort['username'])) : ?>
              <small>
                <i class="fa <?= ($sort['username'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
      <?php endif; ?>
      <div class="col-sm-2 col text-center">
        <?php
          if (isset($sort['o.order_date'])) {
            $order['sort'] = 'o.order_date';
            $order['order'] = ($sort['o.order_date'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'o.order_date';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('orders', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Date
          <?php if(isset($sort['o.order_date'])) : ?>
            <small>
              <i class="fa <?= ($sort['o.order_date'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
      <div class="col-sm-2 col text-center">
        <?php
          if (isset($sort['o.status'])) {
            $order['sort'] = 'o.status';
            $order['order'] = ($sort['o.status'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'o.status';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('orders', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Status
          <?php if(isset($sort['o.status'])) : ?>
            <small>
              <i class="fa <?= ($sort['o.status'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
      <div class="col-sm-2 col text-center">
        <?php
          if (isset($sort['o.total'])) {
            $order['sort'] = 'o.total';
            $order['order'] = ($sort['o.total'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'o.total';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('orders', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Total
          <?php if(isset($sort['o.total'])) : ?>
            <small>
              <i class="fa <?= ($sort['o.total'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
    </div>
  </div>
  <?php foreach ($rows as $row): ?>
    <?php
    $prms['oid'] = $row[0];
    if (!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    $edit_url = _A_::$app->router()->UrlTo('orders/edit', $prms);
    $view_url = _A_::$app->router()->UrlTo('orders/view', $prms);
    ?>
    <div class="col-xs-12 table-list-row">
      <div class="row">
        <div class="col-xs-12 col-sm-3 table-list-row-item">
          <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Order</div>
          </div>
          <div class="col-xs-8 col-sm-12">
            <div class="row cut-text-in-one-line"><?= $row['trid'] ?></div>
          </div>
        </div>
        <?php if (!isset($user_id)): ?>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs helper-row">
              <div class="row">Customer</div>
            </div>
            <div class="col-xs-8 col-sm-12 text-center xs-text-left">
              <div class="row cut-text-in-one-line"><?= $row['username']; ?></div>
            </div>
          </div>
        <?php endif; ?>
        <div class="col-xs-12 col-sm-2 table-list-row-item">
          <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Date</div>
          </div>
          <div class="col-xs-8 col-sm-12 text-center xs-text-left">
            <div class="row"><?= gmdate("m/j/y", $row['order_date']) ?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-2 table-list-row-item">
          <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Status</div>
          </div>
          <div class="col-xs-8 col-sm-12 text-center xs-text-left">
            <div class="row">
              <?= $row['status'] == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>' ?>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-2 table-list-row-item">
          <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Total</div>
          </div>
          <div class="col-xs-8 col-sm-12 text-center xs-text-left">
            <div class="row"><?= '$' . number_format($row['total'], 2); ?></div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-1 text-right action-buttons">
          <?php if (Controller_Admin::is_logged()): ?>
            <a class="update" data-modify href="<?= $edit_url ?>"><i class="fa fa-pencil"></i></a>
          <?php endif; ?>
          <a href="<?= $view_url ?>"><i class="fa fa-eye"></i></a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top">No results found</h2>
  </div>
<?php endif; ?>
