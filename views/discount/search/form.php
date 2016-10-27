<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-search"></i></div>
            <div class="col-xs-10 search-result-list comment-text">
              <?php
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
                      $user_type = 'All new users';
                      break;
                    case 2:
                      $user_type = 'All registered users';
                      break;
                    case 3:
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
                      $product_type = 'All selected fabrics *';
                      break;
                    case 2:
                      $product_type = 'All selected categories *';
                      break;
                    case 3:
                      $product_type = 'All selected manufacturers *';
                      break;
                  }
                  echo '<div class="label label-search-info">Fabrics: ' . $product_type . '</div>';
                }

                if (isset($search['product_type'])) {
                  $product_type = '';
                  switch ($search['product_type']) {
                    case 1:
                      $product_type = 'All selected fabrics *';
                      break;
                    case 2:
                      $product_type = 'All selected categories *';
                      break;
                    case 3:
                      $product_type = 'All selected manufacturers *';
                      break;
                  }
                  echo '<div class="label label-search-info">Fabrics: ' . $product_type . '</div>';
                }
                if (!empty($search['date_start'])) {
                  echo '<div class="label label-search-info">Date from: ' . $search['date_start'] . '</div>';
                }
                if (!empty($search['date_ends'])) {
                  echo '<div class="label label-search-info">Date to: ' . $search['date_ends'] . '</div>';
                }
              ?>
              <?= isset($search['active']) ? '<a data-search_reset title="Reset search" class="button reset">&times;</a>' : '' ?>
            </div>
            <b class="sr-ds"><i class="fa fa-chevron-right"></i></b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">

        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-row">
              <label for="promotion_type">
                Promotion
                <select name="search[promotion_type]" id="promotion_type" class="input-text">
                  <option value="" selected>
                    Select the promotion type
                  </option>
                  <option value="1" <?= ($search['promotion_type'] == 1) ? 'selected' : ''; ?>>
                    Any purchase
                  </option>
                  <option value="2" <?= ($search['promotion_type'] == 2) ? 'selected' : ''; ?>>
                    First purchase
                  </option>
                  <option value="3" <?= ($search['promotion_type'] == 3) ? 'selected' : ''; ?>>
                    Next purchase after the start date
                  </option>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-12 col-sm-5">
            <div class="form-row">
              <label for="user_type">
                Users type
                <select name="search[user_type]" id="user_type" class="input-text">
                  <option value="0" <?= ($search['user_type'] == 0) ? 'selected' : ''; ?>>
                    All users
                  </option>
                  <option value="1" <?= ($search['user_type'] == 1) ? 'selected' : ''; ?>>
                    All new users
                  </option>
                  <option value="2" <?= ($search['user_type'] == 2) ? 'selected' : ''; ?>>
                    All registered users
                  </option>
                  <option value="3" <?= ($search['user_type'] == 3) ? 'selected' : ''; ?>>
                    All selected users (i.e. use the users selected below)
                  </option>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
              <label for="discount_type">
                Discount subtotal type
                <select name="search[discount_type]" id="discount_type">
                  <option value="0" <?= ($search['discount_type'] == 0) ? 'discount_type' : ''; ?>>
                    Any
                  </option>
                  <option value="1" <?= ($search['discount_type'] == 0) ? 'discount_type' : ''; ?>>
                    Sub total
                  </option>
                  <option value="2" <?= ($search['discount_type'] == 0) ? 'discount_type' : ''; ?>>
                    Shipping
                  </option>
                  <option value="3" <?= ($search['discount_type'] == 0) ? 'discount_type' : ''; ?>>
                    Total (inc shipping and handling)
                  </option>
                </select>
              </label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
              <label for="product_type">
                Fabrics
                <select name="search[product_type]" id="product_type">
                  <option value="0" <?= ($search['product_type'] == 0) ? 'product_type' : ''; ?>>
                    All fabrics
                  </option>
                  <option value="1" <?= ($search['product_type'] == 0) ? 'product_type' : ''; ?>>
                    All selected fabrics *
                  </option>
                  <option value="2" <?= ($search['product_type'] == 0) ? 'product_type' : ''; ?>>
                    All selected categories *
                  </option>
                  <option value="3" <?= ($search['product_type'] == 0) ? 'product_type' : ''; ?>>
                    All selected manufacturers *
                  </option>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-6 col-sm-4">
            <div class="form-row">
              <label for="discount_on">
                Date ranges from:
                <input type="text" id="date-from" class="input-text" name="search[date_start]"
                       placeholder="Chose start date"
                       value="<?= isset($search['date_start']) ? $search['date_start'] : '' ?>">
              </label>
            </div>
          </div>
          <div class="col-xs-6 col-sm-4">
            <div class="form-row">
              <label for="discount_on">
                Date ranges to:
                <input type="text" id="date-to" class="input-text" name="search[date_end]"
                       placeholder="Chose end date"
                       value="<?= isset($search['date_end']) ? $search['date_end'] : '' ?>">
              </label>
            </div>
          </div>
        </div>

      </div>

      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-sm-12">
            <a data-search_submit class="button pull-right">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script src="<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>"></script>