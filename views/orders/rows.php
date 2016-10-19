<div class="col-xs-12 table-list-header hidden-xs">
  <div class="row">
    <div class="col-sm-3 col">
      Order <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <?php if(Controller_Admin::is_logged()): ?>
      <div class="col-sm-2 col text-center">
        Customer <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
      </div>
    <?php endif; ?>
    <div class="col-sm-2 col text-center">
      Date <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-2 col text-center">
      Status <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-2 col text-center">
      Total <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
  </div>
</div>
<?php foreach($rows as $row): ?>
  <?php
  $prms['oid'] = $row[0];
  if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
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
      <?php if(!isset($user_id)): ?>
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
          <div class="row"><?=  gmdate("m/j/y", $row['order_date']) ?></div>
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
        <?php if(Controller_Admin::is_logged()): ?>
          <a class="update" data-modify href="<?= $edit_url ?>"><i class="fa fa-pencil"></i></a>
        <?php endif; ?>
        <a href="<?= $view_url ?>"><i class="fa fa-eye"></i></a>
      </div>
    </div>
  </div>
<?php endforeach; ?>