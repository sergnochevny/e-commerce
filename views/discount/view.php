<div class="container">
  <div id="content" class="main-content-inner" role="main">

    <div class="row">
      <div class="col-xs-12">
        <div class="row afterhead-row">
          <div class="col-sm-2 back_button_container">
            <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
              Back
            </a>
          </div>
          <div class="col-sm-8 text-center">
            <div class="row">
              <h3 class="page-title">Discount usage details</h3>
            </div>
          </div>
          <div class="col-sm-2 text-center"></div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-12 table-list-header hidden-xs">
          <div class="row">
            <div class="col-sm-2 col">
              Details <a href="javascript:void(0);">
                <small><i class="fa fa-chevron-down"></i></small>
              </a>
            </div>
            <div class="col-sm-2 col">
              Enabled <a href="javascript:void(0);">
                <small><i class="fa fa-chevron-down"></i></small>
              </a>
            </div>
            <div class="col-sm-2 col">
              Multiple <a href="javascript:void(0);">
                <small><i class="fa fa-chevron-down"></i></small>
              </a>
            </div>
            <div class="col-sm-2 col">
              Coupon <a href="javascript:void(0);">
                <small><i class="fa fa-chevron-down"></i></small>
              </a>
            </div>
            <div class="col-sm-2 col">
              Starts <a href="javascript:void(0);">
                <small><i class="fa fa-chevron-down"></i></small>
              </a>
            </div>
            <div class="col-sm-2 col">
              Ends <a href="javascript:void(0);">
                <small><i class="fa fa-chevron-down"></i></small>
              </a>
            </div>
          </div>
        </div>
        <div class="col-xs-12 table-list-row">
          <div class="row">
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Details</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row cut-text-in-one-line"><?= $discount['discount_amount']; ?>%
                  off </b><?= $discount['discount_comment1']; ?></div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">On</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row"><?= $discount['enabled'] ?></div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Multiple</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row"><?= $discount['allow_multiple'] ?></div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Coupon</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row"><?= !empty($discount['coupon_code']) ? $discount['coupon_code'] : 'N/A'; ?></div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Starts</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row"><?= date("m/d/Y", $discount['date_start']); ?></div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-2 table-list-row-item">
              <div class="col-xs-4 visible-xs">
                <div class="row">Starts</div>
              </div>
              <div class="col-xs-8 col-sm-12">
                <div class="row"><?= date("m/d/Y", $discount['date_end']); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 text-center" style="margin-top: 30px">
          <h4>ORDERS</h4>
        </div>
      </div>

      <?php if(count($orders) > 0): ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="row">
            <div class="col-xs-12 table-list-header hidden-xs">
              <div class="col-sm-4 col">
                Order <a href="javascript:void(0);">
                  <small><i class="fa fa-chevron-down"></i></small>
                </a>
              </div>
              <?php if(Controller_Admin::is_logged()): ?>
                <div class="col-sm-2 col">
                  Customer <a href="javascript:void(0);">
                    <small><i class="fa fa-chevron-down"></i></small>
                  </a>
                </div>
              <?php endif; ?>
              <div class="col-sm-2 col">
                Date
              </div>
              <div class="col-sm-1 col">
                Status
              </div>
              <div class="col-sm-2 col">
                Total
              </div>
            </div>
            <?php foreach($orders as $order): ?>
              <?php
              $prms['oid'] = $order[0];
              $prms['sid'] = _A_::$app->get('sid');
              $prms['discount'] = true;
              if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
              $edit_url = _A_::$app->router()->UrlTo('orders/edit', $prms);
              $view_url = _A_::$app->router()->UrlTo('orders/view', $prms);
              ?>
              <div class="col-xs-12 table-list-row">
                <div class="row">
                  <div class="col-xs-12 col-sm-4 table-list-row-item">
                    <div class="col-xs-4 visible-xs">
                      <div class="row">Order</div>
                    </div>
                    <div class="col-xs-8 col-sm-12">
                      <div class="row cut-text-in-one-line"><?= $order['trid'] ?></div>
                    </div>
                  </div>
                  <?php if(!isset($user_id)): ?>
                    <div class="col-xs-12 col-sm-2 table-list-row-item">
                      <div class="col-xs-4 visible-xs">
                        <div class="row">Customer</div>
                      </div>
                      <div class="col-xs-8 col-sm-12">
                        <div class="row cut-text-in-one-line"><?= $order['username']; ?></div>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="col-xs-12 col-sm-2 table-list-row-item">
                    <div class="col-xs-4 visible-xs">
                      <div class="row">Date</div>
                    </div>
                    <div class="col-xs-8 col-sm-12">
                      <div class="row"><?= gmdate("m/j/y, g:i a", $order['order_date']) ?></div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-1 table-list-row-item">
                    <div class="col-xs-4 visible-xs">
                      <div class="row">Status</div>
                    </div>
                    <div class="col-xs-8 col-sm-12 text-center">
                      <div class="row">
                        <?= $order['status'] == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>' ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-2 table-list-row-item">
                    <div class="col-xs-4 visible-xs">
                      <div class="row">Total</div>
                    </div>
                    <div class="col-xs-8 col-sm-12">
                      <div class="row"><?= '$' . number_format($order['total'], 2); ?></div>
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
          <div class="row">
            <div class="col-xs-12 text-center">
              <span>There is no orders with this discount</span>
            </div>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>
