<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
            <div class="h4 col-xs-10 search-result-list comment-text">
              <?php
                if (isset($search['coupon_code'])) {
                  echo '<div class="label label-search-info">Coupon Code Like: ' . $search['coupon_code'] . '</div>';
                }

                if (isset($search['promotion_type'])) {
                  $promotion = '';
                  switch ($search['promotion_type']) {
                    case 1:
                      $promotion = 'Any purchase';
                      break;
                    case 2:
                      $promotion = 'First purchase';
                      break;
                    case 3:
                      $promotion = 'Next purchase after the start date';
                      break;
                  }
                  echo '<div class="label label-search-info">Promotion: ' . $promotion . '</div>';
                }

                if (isset($search['user_type'])) {
                  $user_type = '';
                  switch ($search['user_type']) {
                    case 1:
                      $user_type = 'All users';
                      break;
                    case 2:
                      $user_type = 'All new users';
                      break;
                    case 3:
                      $user_type = 'All registered users';
                      break;
                    case 4:
                      $user_type = 'All selected users (i.e. use the users selected below)';
                      break;
                  }
                  echo '<div class="label label-search-info">Users type: ' . $user_type . '</div>';
                }

                if (isset($search['discount_type'])) {
                  $discount_type = '';
                  switch ($search['discount_type']) {
                    case 1:
                      $discount_type = 'Sub total';
                      break;
                    case 2:
                      $discount_type = 'Shipping';
                      break;
                    case 3:
                      $discount_type = 'Total (inc shipping and handling)';
                      break;
                  }
                  echo '<div class="label label-search-info">Discount subtotal type: ' . $discount_type . '</div>';
                }

                if (isset($search['product_type'])) {
                  $product_type = '';
                  switch ($search['product_type']) {
                    case 1:
                      $product_type = 'All fabrics';
                      break;
                    case 2:
                      $product_type = 'All selected fabrics';
                      break;
                    case 3:
                      $product_type = 'All selected categories';
                      break;
                    case 4:
                      $product_type = 'All selected manufacturers';
                      break;
                  }
                  echo '<div class="label label-search-info">Fabrics: ' . $product_type . '</div>';
                }

                if (!empty($search['date_start'])) {
                  echo '<div class="label label-search-info">Date from: ' . $search['date_start'] . '</div>';
                }
                if (!empty($search['date_end'])) {
                  echo '<div class="label label-search-info">Date to: ' . $search['date_end'] . '</div>';
                }
              ?>
              <?= isset($search['active']) ? '<a data-search_reset  href="javascript:void(0)" title="Reset search" class="reset"><i class="fa fa-2x fa-times" aria-hidden="true"></i></a>' : '' ?>
            </div>
            <b class="sr-ds"><i class="fa fa-2x fa-chevron-right"></i></b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">

        <div class="row">
          <div class="col-xs-12 col-sm-8">
            <div class="form-row">
              <label>Coupon Code</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[coupon_code]"
                     value="<?= isset($search['coupon_code']) ? $search['coupon_code'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
              <label for="promotion_type">
                Promotion
              </label>
              <select name="search[promotion_type]" id="promotion_type" class="input-text">
                <option value="" <?= (isset($search['promotion_type'])) ? '' : 'selected' ?>>
                  Any
                </option>
                <option
                  value="1" <?= (isset($search['promotion_type']) && $search['promotion_type'] == 1) ? 'selected' : ''; ?>>
                  Any purchase
                </option>
                <option
                  value="2" <?= (isset($search['promotion_type']) && $search['promotion_type'] == 2) ? 'selected' : ''; ?>>
                  First purchase
                </option>
                <option
                  value="3" <?= (isset($search['promotion_type']) && $search['promotion_type'] == 3) ? 'selected' : ''; ?>>
                  Next purchase after the start date
                </option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
              <label for="user_type">
                Users type
              </label>
              <select name="search[user_type]" id="user_type" class="input-text">
                <option value="" <?= (isset($search['user_type'])) ? '' : 'selected' ?>>
                  Any
                </option>
                <option value="1" <?= (isset($search['user_type']) && $search['user_type'] == 1) ? 'selected' : ''; ?>>
                  All users
                </option>
                <option value="2" <?= (isset($search['user_type']) && $search['user_type'] == 2) ? 'selected' : ''; ?>>
                  All new users
                </option>
                <option value="3" <?= (isset($search['user_type']) && $search['user_type'] == 3) ? 'selected' : ''; ?>>
                  All registered users
                </option>
                <option value="4" <?= (isset($search['user_type']) && $search['user_type'] == 4) ? 'selected' : ''; ?>>
                  All selected users (i.e. use the users selected below)
                </option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
              <label for="discount_type">
                Discount subtotal type
              </label>
              <select name="search[discount_type]" id="discount_type">
                <option value="" <?= (isset($search['discount_type'])) ? '' : 'selected' ?>>
                  Any
                </option>
                <option
                  value="1" <?= (isset($search['discount_type']) && $search['discount_type'] == 1) ? 'discount_type' : ''; ?>>
                  Sub total
                </option>
                <option
                  value="2" <?= (isset($search['discount_type']) && $search['discount_type'] == 2) ? 'discount_type' : ''; ?>>
                  Shipping
                </option>
                <option
                  value="3" <?= (isset($search['discount_type']) && $search['discount_type'] == 3) ? 'discount_type' : ''; ?>>
                  Total (inc shipping and handling)
                </option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
              <label for="product_type">
                Fabrics
              </label>
              <select name="search[product_type]" id="product_type">
                <option value="" <?= (isset($search['product_type'])) ? '' : 'selected' ?>>
                  Any
                </option>
                <option
                  value="1" <?= (isset($search['product_type']) && $search['product_type'] == 1) ? 'product_type' : ''; ?>>
                  All fabrics
                </option>
                <option
                  value="2" <?= (isset($search['product_type']) && $search['product_type'] == 2) ? 'product_type' : ''; ?>>
                  All selected fabrics
                </option>
                <option
                  value="3" <?= (isset($search['product_type']) && $search['product_type'] == 3) ? 'product_type' : ''; ?>>
                  All selected categories
                </option>
                <option
                  value="4" <?= (isset($search['product_type']) && $search['product_type'] == 4) ? 'product_type' : ''; ?>>
                  All selected manufacturers
                </option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-row">
              <label for="discount_on">
                Date ranges from:
              </label>
              <input type="text" id="date-from" class="input-text" name="search[date_start]"
                     placeholder="Chose start date"
                     value="<?= isset($search['date_start']) ? $search['date_start'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-row">
              <label for="discount_on">
                Date ranges to:
              </label>
              <input type="text" id="date-to" class="input-text" name="search[date_end]"
                     placeholder="Chose end date"
                     value="<?= isset($search['date_end']) ? $search['date_end'] : '' ?>">
            </div>
          </div>
        </div>

      </div>

      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-xs-12">
            <a data-search_submit class="button pull-right" href="<?= $action ?>">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script src="<?= _A_::$app->router()->UrlTo('js/search.min.js'); ?>"></script>