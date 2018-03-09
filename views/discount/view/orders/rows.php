<?php

use app\core\App;
use classes\helpers\AdminHelper;
use classes\helpers\UserHelper;

?>
<?php if(isset($rows) && count($rows) > 0): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-3 col">
          <?php
          if(isset($sort['a.trid'])) {
            $order['sort'] = 'a.trid';
            $order['order'] = ($sort['a.trid'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'trid';
            $order['order'] = 'desc';
          }
          $order['sid'] = App::$app->get('sid');
          $sort_url = App::$app->router()->UrlTo('discount/view', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Order
            <?php if(isset($sort['a.trid'])) : ?>
              <small>
                <i class="fa <?= ($sort['a.trid'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <?php if(AdminHelper::is_logged()): ?>
          <?php
          if(isset($sort['username'])) {
            $order['sort'] = 'username';
            $order['order'] = ($sort['username'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'username';
            $order['order'] = 'desc';
          }
          $order['sid'] = App::$app->get('sid');
          $sort_url = App::$app->router()->UrlTo('discount/view', $order);
          ?>
          <div class="col-sm-2 col">
            <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
              Customer
              <?php if(isset($sort['username'])) : ?>
                <small>
                  <i class="fa <?= ($sort['username'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
                </small>
              <?php endif; ?>
            </a>
          </div>
        <?php endif; ?>
        <div class="col-sm-2 col">
          <?php
          if(isset($sort['a.order_date'])) {
            $order['sort'] = 'a.order_date';
            $order['order'] = ($sort['a.order_date'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'a.order_date';
            $order['order'] = 'desc';
          }
          $order['sid'] = App::$app->get('sid');
          $sort_url = App::$app->router()->UrlTo('discount/view', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Date
            <?php if(isset($sort['a.order_date'])) : ?>
              <small>
                <i
                  class="fa <?= ($sort['a.order_date'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-2 col">
          <?php
          if(isset($sort['a.status'])) {
            $order['sort'] = 'a.status';
            $order['order'] = ($sort['a.status'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'a.status';
            $order['order'] = 'desc';
          }
          $order['sid'] = App::$app->get('sid');
          $sort_url = App::$app->router()->UrlTo('discount/view', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Status
            <?php if(isset($sort['a.status'])) : ?>
              <small>
                <i class="fa <?= ($sort['a.status'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-2 col">
          <?php
          if(isset($sort['a.total'])) {
            $order['sort'] = 'a.total';
            $order['order'] = ($sort['a.total'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'a.total';
            $order['order'] = 'desc';
          }
          $order['sid'] = App::$app->get('sid');
          $sort_url = App::$app->router()->UrlTo('discount/view', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Total
            <?php if(isset($sort['a.total'])) : ?>
              <small>
                <i class="fa <?= ($sort['a.total'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
      </div>

      <form data-sort title="Click to sort by this column">
        <input type="hidden" name="sort" value="<?= array_keys($sort)[0] ?>">
        <input type="hidden" name="order" value="<?= array_values($sort)[0] ?>">
      </form>

    </div>
    <?php foreach($rows as $row): ?>
      <?php
      $prms['oid'] = $row['oid'];
      $prms['sid'] = App::$app->get('sid');
      $prms['discount'] = true;
      $view_url = App::$app->router()->UrlTo('orders/view', $prms);
      ?>
      <div class="col-xs-12 table-list-row">
        <div class="row">
          <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Order</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row cut-text-in-one-line"><?= $row['trid'] ?></div>
            </div>
          </div>
          <?php if(!isset($user_id) && !UserHelper::is_logged()): ?>
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Customer</div>
              </div>
              <div class="col-xs-8 col-sm-12 xs-text-left">
                <div class="row cut-text-in-one-line"><?= $row['username']; ?></div>
              </div>
            </div>
          <?php endif; ?>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Date</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= gmdate("m/j/y", $row['order_date']) ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Status</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row">
                <?= $row['status'] == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>' ?>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Total</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= '$' . number_format($row['total'], 2); ?></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 text-center action-buttons">
            <a class="no-float" data-waitloader title="View Order Details" href="<?= $view_url ?>"><i
                class="fa fa-2x fa-file-text"></i></a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="col-xs-12 text-center inner-offset-vertical">
    <span class="h3">No results found</span>
  </div>
<?php endif; ?>
