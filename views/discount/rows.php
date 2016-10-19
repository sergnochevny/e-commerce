<div class="col-xs-12 table-list-header hidden-xs">
  <div class="row">
    <div class="col-sm-2 col">
      Details <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-1 col text-center">
      On
    </div>
    <div class="col-sm-2 col text-center">
      Multiple
    </div>
    <div class="col-sm-2 col text-center">
      Coupon <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-2 col text-center">
      Starts <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-2 col text-center">
      Ends <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
  </div>
</div>
<?php foreach($rows as $row): ?>
  <?php
  $prms['sid'] = $row['sid'];
  if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
  $row['date_start'] = gmdate("m/j/y", $row['date_start']);
  $row['date_end'] = gmdate("m/j/y", $row['date_end']);
  $row['enabled'] = $row['enabled'] == "1" ? "YES" : "NO";
  $row['allow_multiple'] = $row['allow_multiple'] == "1" ? "YES" : "NO";
  ?>
  <div class="col-xs-12 table-list-row">
    <div class="row">
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Details</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row cut-text-in-one-line"><?= $row['discount_amount']; ?>% off </b><?= $row['discount_comment1']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-1 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">On</div>
        </div>
        <div class="col-xs-8 col-sm-12 text-center xs-text-left">
          <div class="row"><?= $row['enabled'] ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Multiple</div>
        </div>
        <div class="col-xs-8 col-sm-12 text-center xs-text-left">
          <div class="row"><?= $row['allow_multiple'] ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Coupon</div>
        </div>
        <div class="col-xs-8 col-sm-12 text-center xs-text-left">
          <div class="row"><?= !empty($row['coupon_code']) ? $row['coupon_code'] : 'N/A'; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Starts</div>
        </div>
        <div class="col-xs-8 col-sm-12 text-center xs-text-left">
          <div class="row"><?= $row['date_start']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Starts</div>
        </div>
        <div class="col-xs-8 col-sm-12 text-center xs-text-left">
          <div class="row"><?= $row['date_end']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
        <a data-waitloader rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/edit', $prms); ?>">
          <i class="fa fa-pencil"></i>
        </a>
        <a data-waitloader class="text-success" rel="nofollow"
           href="<?= _A_::$app->router()->UrlTo('discount/view', $prms); ?>">
          <i class="fa fa-check-circle"></i>
        </a>
        <a data-delete class="text-danger" rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/del', $prms); ?>">
          <i class=" fa fa-trash-o"></i>
        </a>
      </div>
    </div>
  </div>
<?php endforeach; ?>