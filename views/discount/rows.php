<?php if(sizeof($rows) > 0): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-2 col">
          <?php
            if(isset($sort['discount_amount'])) {
              $order['sort'] = 'discount_amount';
              $order['order'] = ($sort['discount_amount'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'discount_amount';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('discount', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Details
            <?php if(isset($sort['discount_amount'])) : ?>
              <small>
                <i class="fa <?= ($sort['discount_amount'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-1 col">
          <?php
            if(isset($sort['enabled'])) {
              $order['sort'] = 'enabled';
              $order['order'] = ($sort['enabled'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'enabled';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('discount', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            On
            <?php if(isset($sort['enabled'])) : ?>
              <small>
                <i class="fa <?= ($sort['enabled'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-2 col">
          <?php
            if(isset($sort['allow_multiple'])) {
              $order['sort'] = 'allow_multiple';
              $order['order'] = ($sort['allow_multiple'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'allow_multiple';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('discount', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Multiple
            <?php if(isset($sort['allow_multiple'])) : ?>
              <small>
                <i class="fa <?= ($sort['allow_multiple'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-2 col">
          <?php
            if(isset($sort['coupon_code'])) {
              $order['sort'] = 'coupon_code';
              $order['order'] = ($sort['coupon_code'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'coupon_code';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('discount', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Coupon
            <?php if(isset($sort['coupon_code'])) : ?>
              <small>
                <i class="fa <?= ($sort['coupon_code'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-2 col">
          <?php
            if(isset($sort['date_start'])) {
              $order['sort'] = 'date_start';
              $order['order'] = ($sort['date_start'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'date_start';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('discount', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Starts
            <?php if(isset($sort['date_start'])) : ?>
              <small>
                <i class="fa <?= ($sort['date_start'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-2 col">
          <?php
            if(isset($sort['date_end'])) {
              $order['sort'] = 'date_end';
              $order['order'] = ($sort['date_end'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'date_end';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('discount', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Ends
            <?php if(isset($sort['date_end'])) : ?>
              <small>
                <i class="fa <?= ($sort['date_end'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
      </div>
      <form data-sort>
        <input type="hidden" name="sort" value="<?= array_keys($sort)[0] ?>">
        <input type="hidden" name="order" value="<?= array_values($sort)[0] ?>">
      </form>
    </div>
    <?php foreach($rows as $row): ?>
      <?php
      $prms['sid'] = $row['sid'];
      $row['date_start'] = gmdate("m/j/y", $row['date_start']);
      $row['date_end'] = gmdate("m/j/y", $row['date_end']);
      $row['enabled'] = $row['enabled'] == "1" ? "YES" : "NO";
      $row['allow_multiple'] = $row['allow_multiple'] == "1" ? "YES" : "NO";
      ?>
      <div class="col-xs-12 table-list-row">
        <div class="row">
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Details</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row cut-text-in-one-line"><?= $row['discount_amount']; ?>%
                off </b><?= $row['discount_comment1']; ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-1 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">On</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= $row['enabled'] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Multiple</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= $row['allow_multiple'] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Coupon</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= !empty($row['coupon_code']) ? $row['coupon_code'] : 'N/A'; ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Starts</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= $row['date_start']; ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Starts</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= $row['date_end']; ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2 text-right action-buttons">
            <a data-waitloader rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/edit', $prms); ?>">
              <i class="fa fa-2x fa-pencil"></i>
            </a>
            <a data-waitloader class="text-success" rel="nofollow"
               href="<?= _A_::$app->router()->UrlTo('discount/view', $prms); ?>">
              <i class="fa fa-2x fa-check-circle"></i>
            </a>
            <a data-delete class="text-danger" rel="nofollow"
               href="<?= _A_::$app->router()->UrlTo('discount/delete', $prms); ?>">
              <i class=" fa fa-2x fa-trash-o"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="col-sm-12 offset-top">
    <h2 class="offset-top">No results found</h2>
  </div>
<?php endif; ?>

