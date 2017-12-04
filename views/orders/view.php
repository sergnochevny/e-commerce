<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="box col-xs-12">
    <div class="col-xs-12">

      <div class="row">
        <div class="col-xs-12">
          <div class="row">

            <div class="col-xs-12 col-sm-2 back_button_container">
              <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                Back
              </a>
            </div>
            <div class="col-xs-12 col-sm-8 text-center">
              <div class="row">
                <h3 class="page-title"><?= isset($user_id) && !$is_admin ? $data[0]['username'] : '' ?>
                  Order details</h3>
              </div>
            </div>

          </div>
        </div>
      </div>


      <div class="row order-details">
        <div class="panel panel-default ">
          <div class="row">

            <div class="col-xs-12 col-sm-4">
              <div class="text-left">
                <div class="col-xs-6 col-md-6 order-detail-item">
                  <b>Track Code:</b>
                </div>
                <div class="col-xs-6 col-md-6 order-detail-item">
                  <?= ($track_code == 0) ? 'Not specified' : $track_code ?>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-4">
              <div class="text-left">
                <div class="col-xs-6 col-md-6 order-detail-item">
                  <b>Delivery date:</b>
                </div>
                <div class="col-xs-6 col-md-6 order-detail-item">
                  <?= ($end_date == 0) ? 'Not specified' : $end_date ?>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-4">
              <div class="text-left">
                <div class="col-xs-6 col-md-6 order-detail-item">
                  <b>Order status:</b>
                </div>
                <div class="col-xs-6 col-md-6 order-detail-item">
                  <?= $status ?>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
    <div class="data-view">
      <div class="col-xs-12 table-list-header hidden-xs">
        <div class="row">
          <div class="col-sm-4 col">
            Product
          </div>
          <div class="col-sm-2 col">
            Item Price
          </div>
          <div class="col-sm-3 col">
            Sale Price
          </div>
          <div class="col-sm-2 col">
            Quantity
          </div>
        </div>
      </div>
      <div class="col-xs-12 table-list-row orders-details">
        <div class="row">

          <?= $detail_info; ?>
          <div class="col-xs-12 table-list-row-item">
            <div class="row">
              <hr style="border-color: #D0D0D0; margin: 1px 0">
            </div>
          </div>
          <?php if($is_sample) { ?>
            <div class="col-xs-12 table-list-row-item">
              <div class="row">
                <div class="col-xs-6 col-sm-4 text-left">
                  Samples cost
                </div>
                <div class="col-xs-6 col-sm-8 text-left">
                  <?= $sample_cost ?>
                </div>
              </div>
            </div>
          <?php } ?>
          <?php if(!empty($shipping_cost)) { ?>
            <div class="col-xs-12 table-list-row-item">
              <div class="row">
                <div class="col-xs-6 col-sm-4 text-left">
                  <?= ($shipping_type == 3 ? 'Ground ship' : 'Express post') ?>
                </div>
                <div class="col-xs-6 col-sm-8 text-left">
                  <?= $shipping_cost ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-sm-offset-6 table-total">
      <div class="table-list-row-item">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="col-xs-6">
              <div class="row text-left">
                <b>Sub Total:</b>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="row text-right">
                <?= $sub_price; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php if(!empty($handling)) { ?>
        <div class="table-list-row-item">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="col-xs-6">
                <div class="row text-left">
                  <b>Handling:</b>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="row text-right">
                  <?= $handling; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php } ?>
      <?php if(!empty($shipping_discount)) { ?>
        <div class="table-list-row-item">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="col-xs-6">
                <div class="row text-left">
                  <b>Shipping Discount:</b>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="row text-right">
                  <?= $shipping_discount; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if(!empty($taxes)) { ?>
        <div class="table-list-row-item">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="col-xs-6">
                <div class="row text-left">
                  <b>Taxes:</b>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="row text-right">
                  <?= $taxes; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <div class="table-list-row-item">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="col-xs-6">
              <div class="row text-left">
                <b class="text-danger">
                  Total:
                </b>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="row text-right">
                <?= $total; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="table-list-row-item">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="col-xs-6">
              <div class="row text-left">
                <b>Total discount:</b>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="row text-right">
                <?= $total_discount; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
