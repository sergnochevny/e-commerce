<div class="container">
  <div class="col-md-12">

    <div class="row">
      <div class="col-md-12"><div class="row"><a href="<?= $back_url; ?>" class="button back_button">Back</a></div></div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-md-4">
        <div class="row text-center">
          <div class="col-xs-4 col-md-6"><div class="row"><b>Track Code:</b></div></div>
          <div class="col-xs-8 col-md-6"><div class="row"><?= ($track_code == 0) ? 'Not set yet' : $track_code ?></div></div>
        </div>
      </div>

      <div class="col-xs-12 col-md-4">
        <div class="row text-center">
          <div class="col-xs-4 col-md-6"><div class="row"><b>Delivery date:</b></div></div>
          <div class="col-xs-8 col-md-6"><div class="row"><?= ($end_date == 0) ? 'Not specified' : $end_date ?></div></div>
        </div>
      </div>

      <div class="col-xs-12 col-md-4">
        <div class="row text-center">
          <div class="col-xs-4 col-md-6"><div class="row"><b>Order status:</b></div></div>
          <div class="col-xs-8 col-md-6"><div class="row"><?= $status ?></div></div>
        </div>
      </div>
    </div>

  </div>

  <div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
      <div class="col-sm-4 col">
        Product <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
      </div>
      <div class="col-sm-2 col-sm-offset-4 col">
        Sale Price <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
      </div>
      <div class="col-sm-2 col">
        Quantity <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
      </div>
    </div>
  </div>
  <div class="col-xs-12 table-list-row">
    <div class="row">

      <?= $detail_info; ?>

      <?php if($is_sample) { ?>
        <div class="col-xs-12 col-sm-4 col-sm-offset-8 table-list-row-item">
          <div class="col-xs-4 helper-row">
            <div class="row">Samples cost</div>
          </div>
          <div class="col-xs-8">
            <div class="row cut-text-in-one-line">
              <?= $sample_cost ?>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if(!empty($shipping_cost)) { ?>
        <div class="col-xs-12 col-sm-4 col-sm-offset-8 table-list-row-item">
          <div class="col-xs-4 helper-row">
            <div class="row"><?= ($shipping_type == 3 ? 'Ground ship' : 'Express post') ?></div>
          </div>
          <div class="col-xs-8">
            <div class="row cut-text-in-one-line">
              <?= $shipping_cost ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 table-list-row-item">
    <div class="row text-right">
      <b>Sub Total:</b>
      <?= $sub_price; ?>
    </div>
  </div>

    <?php if(!empty($handling)) { ?>
      <div class="col-xs-12 col-sm-12 table-list-row-item">
        <div class="row text-right">
          <b>Handling:</b>
          <?= $handling; ?>
        </div>
      </div>
    <?php } ?>
    <?php if(!empty($shipping_discount)) { ?>
      <div class="col-xs-12 col-sm-12 table-list-row-item">
        <div class="row text-right">
          <b>Shipping Discount:</b>
          <?= $shipping_discount; ?>
        </div>
      </div>
    <?php } ?>
    <?php if(!empty($taxes)) { ?>
      <div class="col-xs-12 col-sm-12 table-list-row-item">
        <div class="row text-right">
          <b>Taxes:</b>
          <?= $taxes; ?>
        </div>
      </div>
    <?php } ?>
    <div class="col-xs-12 col-sm-12 table-list-row-item">
      <div class="row text-right">
        <b>Total:</b>
        <?= $total; ?>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 table-list-row-item">
      <div class="row text-right">
        <b>Total discount:</b>
        <?= $total_discount; ?>
      </div>
    </div>

  </div>
</div>
