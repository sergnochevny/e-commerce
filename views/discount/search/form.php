<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-2"><i class="fa fa-search"></i></div>
            <div class="col-xs-9 comment-text">
              <?=isset($search['colour'])?'<span>Like: </span><b>'.$search['colour'].'</b>':''?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-chevron-right"></i>
            </b>
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
                    Any
                  </option>
                  <option value="0" <?= ($search['promotion_type'] == 0) ? 'selected' : ''; ?>>
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
                  <input type="text" id="discount_starts" class="input-text" name="search[date_start]" placeholder="Chose start date"
                    value="<?= isset($search['date_start']) ? $search['date_start'] : '' ?>">
                </label>
            </div>
          </div>
          <div class="col-xs-6 col-sm-4">
            <div class="form-row">
                <label for="discount_on">
                  Date ranges to:
                  <input type="text" id="discount_ends" class="input-text" name="search[date_end]" placeholder="Chose end date"
                         value="<?= isset($search['date_end']) ? $search['date_end'] : '' ?>">
                </label>
            </div>
          </div>
        </div>

      </div>

      <div class="panel-footer hidden">
        <a data-search_submit class="btn button pull-right">Search</a>
        <a data-search_reset class="btn reset">Reset</a>
      </div>
    </div>
  </div>
</form>
<script src="<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>"></script>