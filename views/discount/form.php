<div class="row">
  <?php if(isset($warning)) { ?>
    <div class="col-xs-12 alert-success danger" style="display: none;">
      <?php
        foreach($warning as $msg) {
          echo $msg . '<br/>';
        }
      ?>
    </div>
  <?php }
    if(isset($error)) { ?>
      <div class="col-xs-12 alert-danger danger" style="display: none;">
        <?php foreach($error as $msg) {
          echo $msg . '<br/>';
        } ?>
      </div>
    <?php } ?>
</div>
<form method="POST" id="edit_form" action="<?= $action; ?>" class="col-md-8 col-md-offset-2">
  
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="form-row">
          <div class="col-md-12">
            <label class="required_field">
              Promotion
              <i class="fa fa-question-circle" data-promotion href="#promotion"></i>
            </label>
          </div>
          <div class="col-md-12">
            <select name="promotion_type" class="input-text">
              <option value="0" <?= ($data['promotion_type'] == 0) ? 'selected' : ''; ?>>
                Select the promotion type
              </option>
              <option value="1" <?= ($data['promotion_type'] == 1) ? 'selected' : ''; ?>>
                Any purchase
              </option>
              <option value="2" <?= ($data['promotion_type'] == 2) ? 'selected' : ''; ?>>
                First purchase
              </option>
              <option value="3" <?= ($data['promotion_type'] == 3) ? 'selected' : ''; ?>>
                Next purchase after the start date
              </option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <label for="coupon_code">
                  Coupon Code <i data-promotion href="#coupon_code" class="fa fa-question-circle"></i>
                </label>
              </div>
              <div class="col-xs-12">
                <input type="text" name="coupon_code" id="coupon_code"
                       value="<?= $data['coupon_code'] ?>" class="input-text">
              </div>
              <div class="col-xs-12">
                <label style="font-size: 10px; margin-top: 7px" for="generate_code">
                  <input type="checkbox" name="generate_code" id="generate_code" value="1"
                    <?= (isset($data['generate_code']) && $data['generate_code'] == '1') ? 'checked' : '' ?>
                         class="input-checkbox">
                  Generate Coupon Code for me.</label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <label class="required_field" for="discount_amount">
                  Discount details <i data-promotion href="#discount_details"
                                      class="fa fa-question-circle"></i>
                </label>
              </div>
              <div class="col-xs-4 col-md-4">
                <input type="text" name="discount_amount" value="<?= $data['discount_amount'] ?>" id="discount_amount"
                       class="input-text ">
              </div>
              <div class="col-xs-2 col-md-2">
                <div class="row">
                  <select name="discount_amount_type" style="padding-left: 5px">
                    <option
                      value="1" <?= ($data['discount_amount_type'] == '1') ? 'selected' : '' ?>>
                      $
                    </option>
                    <option
                      value="2" <?= ($data['discount_amount_type'] == '2') ? 'selected' : '' ?>>
                      %
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-md-6">
                <select name="discount_type" id="discount_type">
                  <option value="0" <?= ($data['discount_type'] == '0') ? 'selected' : '' ?>>
                    Select
                  </option>
                  <option value="1" <?= ($data['discount_type'] == '1') ? 'selected' : '' ?>>
                    Sub total
                  </option>
                  <option value="2" <?= ($data['discount_type'] == '2') ? 'selected' : '' ?>>
                    Shipping
                  </option>
                  <option value="3" <?= ($data['discount_type'] == '3') ? 'selected' : '' ?>>
                    Total (inc shipping and handling)
                  </option>
                </select>
              </div>
              <div class="col-md-3" style="display: none;">
                <select name="shipping_type" id="shipping_type">
                  <option value="0">Select Shipping Type</option>
                  <option value="1">Both</option>
                  <option value="2" selected>Ground</option>
                  <option value="3">Express</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <label class="required_field" data-promotion for="required_amount">
                  Restrictions
                  <i data-promotion href="#discount_details" class="fa fa-question-circle"></i>
                </label>
              </div>
              <div class="col-xs-6 col-md-4">
                <input type="text" name="required_amount" id="required_amount" value="<?= $data['required_amount'] ?>"
                       class="input-text ">
              </div>
              <div class="col-xs-6 col-md-8" style="padding-left: 0">
                <select name="required_type">
                  <option value="0" <?= ($data['required_type'] == '0') ? 'selected' : '' ?>>
                    Select
                  </option>
                  <option value="1" <?= ($data['required_type'] == '1') ? 'selected' : '' ?>>
                    Total purchases
                  </option>
                  <option value="2" <?= ($data['required_type'] == '2') ? 'selected' : '' ?>>
                    Total dollar amount
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-xs-12">
            <div class="col-xs-12">
              <label class="required_field" for="">
                Users type <i class="fa fa-question-circle" data-promotion href="#users"></i>
              </label>
            </div>
            <div class="col-md-12 panel panel-default"
                 style="padding-top: 10px; padding-bottom: 10px; border-color: #999;">
              <label style="font-size: 12px;">
                <input type="radio" id="user_type1" name="user_type" value="1"
                       class="input-checkbox" <?= $data['user_type'] == "1" ? 'checked' : ''; ?>>
                All users
              </label>
              <label style="font-size: 12px;">
                <input type="radio" id="user_type2" name="user_type" value="2"
                       class="input-checkbox" <?= $data['user_type'] == "2" ? 'checked' : ''; ?>>
                All new users
              </label>
              <label style="font-size: 12px;">
                <input type="radio" id="user_type3" name="user_type" value="3"
                       class="input-checkbox" <?= $data['user_type'] == "3" ? 'checked' : ''; ?>>
                All registered users
              </label>
              <label style="font-size: 12px;">
                <input type="radio" id="user_type4" data-type="users" name="user_type" value="4"
                       class="input-checkbox" <?= $data['user_type'] == "4" ? 'checked' : ''; ?>>
                All selected users (i.e. use the users selected below)
              </label>
              <div data-filter-panel-users>
                <?php if(isset($data['users'])): ?>
                  <?= $data['users']; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-xs-12">
            <div class="col-xs-12">
              <label class="required_field" for="">
                Fabrics
                <i class="fa fa-question-circle" data-promotion href="#fabrics"></i>
              </label>
            </div>
            <div class="col-md-12 panel panel-default"
                 style="padding-top: 10px; padding-bottom: 10px; border-color: #999;">
              <label style="font-size: 12px;">
                <input type="radio" name="product_type" id="product_type1" value="1"
                       class="input-checkbox" <?= $data['product_type'] == "1" ? 'checked' : '' ?>>
                All fabrics
              </label>
              <label style="font-size: 12px;">
                <input type="radio" name="product_type" id="product_type2" value="2"
                       data-type="filter_products"
                       class="input-checkbox" <?= $data['product_type'] == "2" ? 'checked' : '' ?>>
                All selected fabrics *
              </label>
              <label style="font-size: 12px;">
                <input type="radio" name="product_type" id="product_type3" value="3"
                       data-type="filter_products"
                       class="input-checkbox" <?= $data['product_type'] == "3" ? 'checked' : '' ?>>
                All selected categories *
              </label>
              <label style="font-size: 12px;">
                <input type="radio" name="product_type" id="product_type4" value="4"
                       data-type="filter_products"
                       class="input-checkbox" <?= $data['product_type'] == "4" ? 'checked' : '' ?>>
                All selected manufacturers *
              </label>
              <label style="font-size: 12px;">* - i.e. use the item selected below</label>
              <div data-filter-panel-fabrics>
                <?php if(isset($data['filter_products'])): ?>
                  <?= $data['filter_products']; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-xs-12">
            <label for="allow_multiple">
              <input type="checkbox" value="1" name="allow_multiple"
                     id="allow_multiple" <?= $data['allow_multiple'] == "1" ? 'checked' : '' ?>
                     class="input-checkbox">
              Allow multiple
              <i class="fa fa-question-circle" data-promotion href="#allow_multiple"></i>
            </label>
          </div>
        </div>

        <div class="form-row">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-6">
                <label for="dateFrom"> Start Date
                  <i class="fa fa-question-circle" data-promotionhref="#date_start"></i>
                </label>
                <input type="text" name="date_start" id="dateFrom" value="<?= $data['date_start'] ?>"
                       class="input-text ">
              </div>
              <div class="col-xs-6">
                <label for="dateTo">End Date <i class="fa fa-question-circle" data-promotion href="#date_end"></i></label>
                <input type="text" name="date_end" value="<?= $data['date_end'] ?>" id="dateTo" class="input-text ">
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-xs-12 col-sm-6">
            <label for="enabled">
              <input type="checkbox" value="1" name="enabled" id="enabled"
                <?= $data['enabled'] == "1" ? 'checked' : ''; ?>
                     class="input-checkbox">
              Enabled <i class="fa fa-question-circle" data-promotion=""
                                     href="#enabled"></i>
            </label>
          </div>
          <div class="col-xs-12 col-sm-6">
            <label for="countdown">
              <input type="checkbox" value="1" id="countdown"
                     name="countdown" <?= $data['countdown'] == "1" ? 'checked' : '' ?>
                     class="input-checkbox">
              Disable sale countdown <i class="fa fa-question-circle" data-promotion
                                        href="#disable_sale_countdown"></i>
            </label>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12">
            <label for="discount_comment1">First Comment</label>
            <textarea name="discount_comment1" id="discount_comment1"><?= $data['discount_comment1'] ?></textarea>
            <small class="char-counter help-block">
              <span class="char-counter-output" id="discount_comment1_counter_output"></span>
              <span class="char-counter-notification" id="discount_comment1_counter_notification"></span>
            </small>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12">
            <label for="discount_comment2">Second Comment</label>
            <textarea name="discount_comment2" id="discount_comment2"><?= $data['discount_comment2'] ?></textarea>
            <small class="char-counter help-block">
              <span class="char-counter-output" id="discount_comment2_counter_output"></span>
              <span class="char-counter-notification" id="discount_comment2_counter_notification"></span>
            </small>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12">
            <label for="discount_comment3">Third Comment</label>
            <textarea name="discount_comment3" id="discount_comment3"><?= $data['discount_comment3'] ?></textarea>
            <small class="char-counter help-block">
              <span class="char-counter-output" id="discount_comment3_counter_output"></span>
              <span class="char-counter-notification" id="discount_comment3_counter_notification"></span>
            </small>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 text-center">
            <a id="submit" class="button" style="width: 150px;">
              <?= isset($data['id']) ? 'Update' : 'Save'; ?>
            </a>
            <div class="results" style="color: red;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id="modal-title" class="modal-title text-center"></h4>
        </div>
        <div class="modal-body" style="padding: 0;">
          <div id="modal_content">
          </div>
        </div>
        <div class="modal-footer">
          <a id="build_filter" href="filter" class="btn btn-primary" data-dismiss="modal">Ok</a>
          <a class="btn btn-default" data-dismiss="modal">Close</a>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</form>

<script src="<?= _A_::$app->router()->UrlTo('views/js/char-counter.jquery.js'); ?>"></script>
<script src="<?= _A_::$app->router()->UrlTo('views/js/inputmask/jquery.inputmask.bundle.min.js'); ?>"></script>
<script src="<?= _A_::$app->router()->UrlTo('views/js/discount/form.js'); ?>"></script>
