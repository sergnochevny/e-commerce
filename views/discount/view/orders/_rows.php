<?php if(isset($rows) && (count($rows) > 0)): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-4 col">Order</div>
        <?php if(Controller_Admin::is_logged()): ?>
          <div class="col-sm-2 col">Customer</div>
        <?php endif; ?>
        <div class="col-sm-2 col">Date</div>
        <div class="col-sm-1 col">Status</div>
        <div class="col-sm-2 col">Total</div>
      </div>
      <?php foreach($rows as $row): ?>
        <?php
        $prms['oid'] = $row['oid'];
        $prms['sid'] = _A_::$app->get('sid');
        $prms['discount'] = true;
        $view_url = _A_::$app->router()->UrlTo('orders/view', $prms);
        ?>
        <div class="col-xs-12 table-list-row">
          <div class="row">
            <div class="col-xs-12 col-sm-4 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Order</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row cut-text-in-one-line"><?= $row['trid'] ?></div>
              </div>
            </div>
            <?php if(!isset($user_id)): ?>
              <div class="col-xs-12 col-sm-2 table-list-row-item">
                <div class="col-xs-4 visible-xs">
                  <div class="row">Customer</div>
                </div>
                <div class="col-xs-8 col-sm-12">
                  <div class="row cut-text-in-one-line"><?= $row['username']; ?></div>
                </div>
              </div>
            <?php endif; ?>
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Date</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row"><?= gmdate("m/j/y, g:i a", $row['order_date']) ?></div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-1 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Status</div>
              </div>
              <div class="col-xs-8 col-sm-12 text-center">
                <div class="row">
                  <?= $row['status'] == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>' ?>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Total</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row"><?= '$' . number_format($row['total'], 2); ?></div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-1 text-right action-buttons">
              <a href="<?= $view_url ?>"><i class="fa fa-2x fa-eye"></i></a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php else: ?>
  <div class="col-xs-12 text-center">
    <span>There is no orders with this discount</span>
  </div>
<?php endif; ?>
