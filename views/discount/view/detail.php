<?php
  $data['date_start'] = gmdate("m/j/y", $data['date_start']);
  $data['date_end'] = gmdate("m/j/y", $data['date_end']);
  $data['enabled'] = $data['enabled'] == "1" ? "Yes" : "No";
  $data['allow_multiple'] = $data['allow_multiple'] == "1" ? "Yes" : "No";
?>
<div class="data-view">
  <div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
      <div class="col-sm-2 col">Details</div>
      <div class="col-sm-2 col">Enabled</div>
      <div class="col-sm-2 col">Multiple</div>
      <div class="col-sm-2 col">Coupon</div>
      <div class="col-sm-2 col">Starts</div>
      <div class="col-sm-2 col">Ends</div>
    </div>
  </div>
  <div class="col-xs-12 table-list-row">
    <div class="row">
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs">
          <div class="row">Details</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row cut-text-in-one-line">
            <?= $data['discount_amount']; ?>% off
            </br><?= $data['discount_comment1']; ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs">
          <div class="row">On</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $data['enabled']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs">
          <div class="row">Multiple</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $data['allow_multiple']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs">
          <div class="row">Coupon</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= !empty($data['coupon_code']) ? $data['coupon_code'] : 'N/A'; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs">
          <div class="row">Starts</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $data['date_start']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs">
          <div class="row">Starts</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $data['date_end']; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
