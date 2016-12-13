<?php include_once 'views/messages/alert-boxes.php'; ?>
<form method="POST" id="edit_form" action="<?= $action; ?>" class="col-sm-12 col-md-10 col-md-offset-1">
  <div class="tabs col-xs-12">

    <div class="col-xs-12 col-sm-2 tab">
      <ul class="tabNavigation">
        <li><a class="" href="#first">System</a></li>
        <li><a class="" href="#second">Shop</a></li>
      </ul>
    </div>

    <div class="col-xs-12 col-sm-10">
      <div data-role="tab" id="first">
        <div class="row">
          <div class="col-xs-12 text-center">
            <h3>System</h3>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <div class="form-row">
                <div class="col-xs-6">
                  <label>
                    <input type="checkbox" name="system_demo" value="1"
                      <?= (isset($data['system_demo']) && $data['system_demo'] == '1') ? 'checked' : '' ?>
                           class="input-checkbox">
                    Demo mode.
                  </label>
                </div>
                <div class="col-xs-6">
                  <label>
                    <input type="checkbox" name="system_enable_sef" value="1"
                      <?= (isset($data['system_enable_sef']) && $data['system_enable_sef'] == '1') ? 'checked' : '' ?>
                           class="input-checkbox">
                    Enable SEF.
                  </label>
                </div>

                <div class="col-xs-12 col-sm-6">
                  <label>
                    Filter limit amount
                  </label>
                  <select name="system_filter_amount" class="input-text">
                    <option value="25" <?= ($data['system_filter_amount'] == 25) ? 'selected' : ''; ?>>
                      by 25 rows
                    </option>
                    <option value="50" <?= ($data['system_filter_amount'] == 50) ? 'selected' : ''; ?>>
                      by 50 rows
                    </option>
                    <option value="100" <?= ($data['system_filter_amount'] == 100) ? 'selected' : ''; ?>>
                      by 100 rows
                    </option>
                  </select>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <label>
                    Captcha relevant time
                  </label>
                  <select name="system_captcha_time" class="input-text">
                    <option value="120" <?= ($data['system_captcha_time'] == 120) ? 'selected' : ''; ?>>
                      2 min.
                    </option>
                    <option value="300" <?= ($data['system_captcha_time'] == 300) ? 'selected' : ''; ?>>
                      5 min.
                    </option>
                    <option value="600" <?= ($data['system_captcha_time'] == 600) ? 'selected' : ''; ?>>
                      10 min.
                    </option>
                    <option value="1800" <?= ($data['system_captcha_time'] == 1800) ? 'selected' : ''; ?>>
                      30 min.
                    </option>
                  </select>
                </div>
                <div class="col-xs-12">
                  <label class="required_field">
                    System information email
                  </label>
                  <input type="email" name="system_info_email" class="input-text"
                         value="<?= $data['system_info_email']; ?>"/>
                </div>
                <div class="col-xs-12">
                  <label>
                    <input type="checkbox" name="system_csv_use_gz" id="generate_code" value="1"
                      <?= (isset($data['system_csv_use_gz']) && $data['system_csv_use_gz'] == '1') ? 'checked' : '' ?>
                           class="input-checkbox">
                    Export Users CSV use gz compression.
                  </label>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>

      <div data-role="tab" id="second">
        <div class="row">
          <div class="col-xs-12 text-center">
            <h3>Shop</h3>
          </div>
          <div class="col-xs-12">
            <div class="col-xs-12">
              <div class="row">
                <div class="form-row">
                  <div class="col-xs-12 col-sm-6">
                    <label>
                      <input type="checkbox" name="system_allow_sample_express_shipping" value="1"
                        <?= (isset($data['system_allow_sample_express_shipping']) && $data['system_allow_sample_express_shipping'] == '1') ? 'checked' : '' ?>
                             class="input-checkbox">
                      Allow Sample EXPRESS SHIPPING.
                    </label>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <label>
                      <input type="checkbox" name="system_hide_all_regular_prices" value="1"
                        <?= (isset($data['system_hide_all_regular_prices']) && $data['system_hide_all_regular_prices'] == '1') ? 'checked' : '' ?>
                             class="input-checkbox">
                      Hide all regular prices.
                    </label>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <label class="required_field">
                      PayPal Business Account
                    </label>
                    <input type="email" name="paypal_business" class="input-text"
                           value="<?= $data['paypal_business']; ?>"/>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <label class="required_field">
                      PayPal proceed URI
                    </label>
                    <input type="url" name="paypal_url" class="input-text" value="<?= $data['paypal_url']; ?>"/>
                  </div>
                  <div class="col-xs-12">
                    <label class="required_field">
                      Promotion
                      <i class="fa fa-question-circle" data-promotion href="#promotion"></i>
                    </label>
                  </div>
                  <div class="col-xs-12">
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
                  <div class="col-xs-12">
                    <div class="row">
                      <div class="col-xs-12">
                        <label class="required_field" for="discount_amount">
                          Discount details <i data-promotion href="#discount_details"
                                              class="fa fa-question-circle"></i>
                        </label>
                      </div>
                      <div class="col-xs-4 col-md-4">
                        <input data-inputmask="'mask': '9[9].9[9]', 'greedy' : false" type="text"
                               name="discount_amount" value="<?= $data['discount_amount'] ?>" id="discount_amount"
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
                  <div class="col-xs-12">
                    <div class="row">
                      <div class="col-xs-12">
                        <label class="required_field" data-promotion for="required_amount">
                          Restrictions
                          <i data-promotion href="#discount_details" class="fa fa-question-circle"></i>
                        </label>
                      </div>
                      <div class="col-xs-6 col-md-4">
                        <input data-inputmask="'mask': '9[9{3}].9[9]', 'greedy' : false" type="text"
                               name="required_amount" id="required_amount" value="<?= $data['required_amount'] ?>"
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
                  <div class="col-xs-12">
                    <div class="col-xs-12">
                      <label class="required_field" for="">
                        Users type <i class="fa fa-question-circle" data-promotion href="#users"></i>
                      </label>
                    </div>
                    <div class="col-xs-12 panel panel-default"
                         style="padding-top: 10px; padding-bottom: 10px; border-color: #999;">
                      <label style="font-size: 12px; width: 100%;">
                        <input type="radio" id="user_type1" name="user_type" value="1"
                               class="input-checkbox" <?= $data['user_type'] == "1" ? 'checked' : ''; ?>>
                        All users
                      </label>
                      <label style="font-size: 12px; width: 100%;">
                        <input type="radio" id="user_type2" name="user_type" value="2"
                               class="input-checkbox" <?= $data['user_type'] == "2" ? 'checked' : ''; ?>>
                        All new users
                      </label>
                      <label style="font-size: 12px; width: 100%;">
                        <input type="radio" id="user_type3" name="user_type" value="3"
                               class="input-checkbox" <?= $data['user_type'] == "3" ? 'checked' : ''; ?>>
                        All registered users
                      </label>
                      <label style="font-size: 12px; width: 100%;">
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
                  <div class="col-xs-12">
                    <div class="col-xs-12">
                      <label class="required_field" for="">
                        Fabrics
                        <i class="fa fa-question-circle" data-promotion href="#fabrics"></i>
                      </label>
                    </div>
                    <div class="col-xs-12 panel panel-default"
                         style="padding-top: 10px; padding-bottom: 10px; border-color: #999;">
                      <label style="font-size: 12px; width: 100%;">
                        <input type="radio" name="product_type" id="product_type1" value="1"
                               class="input-checkbox" <?= $data['product_type'] == "1" ? 'checked' : '' ?>>
                        All fabrics
                      </label>
                      <label style="font-size: 12px; width: 100%;">
                        <input type="radio" name="product_type" id="product_type2" value="2"
                               data-type="filter_products"
                               class="input-checkbox" <?= $data['product_type'] == "2" ? 'checked' : '' ?>>
                        All selected fabrics *
                      </label>
                      <label style="font-size: 12px; width: 100%;">
                        <input type="radio" name="product_type" id="product_type3" value="3"
                               data-type="filter_products"
                               class="input-checkbox" <?= $data['product_type'] == "3" ? 'checked' : '' ?>>
                        All selected categories *
                      </label>
                      <label style="font-size: 12px; width: 100%;">
                        <input type="radio" name="product_type" id="product_type4" value="4"
                               data-type="filter_products"
                               class="input-checkbox" <?= $data['product_type'] == "4" ? 'checked' : '' ?>>
                        All selected manufacturers *
                      </label>
                      <label style="font-size: 12px; width: 100%;">* - i.e. use the item selected below</label>
                      <div data-filter-panel-fabrics>
                        <?php if(isset($data['filter_products'])): ?>
                          <?= $data['filter_products']; ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12">
                    <label for="allow_multiple">
                      <input type="checkbox" value="1" name="allow_multiple"
                             id="allow_multiple" <?= $data['allow_multiple'] == "1" ? 'checked' : '' ?>
                             class="input-checkbox">
                      Allow multiple
                      <i class="fa fa-question-circle" data-promotion href="#allow_multiple"></i>
                    </label>
                  </div>

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
                        <label for="dateTo">End Date <i class="fa fa-question-circle" data-promotion
                                                        href="#date_end"></i></label>
                        <input type="text" name="date_end" value="<?= $data['date_end'] ?>" id="dateTo"
                               class="input-text ">
                      </div>
                    </div>
                  </div>

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

                  <div class="col-xs-12">
                    <label for="discount_comment1">First Comment</label>
                    <textarea name="discount_comment1"
                              id="discount_comment1"><?= $data['discount_comment1'] ?></textarea>
                    <small class="char-counter help-block">
                      <span class="char-counter-output" id="discount_comment1_counter_output"></span>
                      <span class="char-counter-notification" id="discount_comment1_counter_notification"></span>
                    </small>
                  </div>

                  <div class="col-xs-12">
                    <label for="discount_comment2">Second Comment</label>
                    <textarea name="discount_comment2"
                              id="discount_comment2"><?= $data['discount_comment2'] ?></textarea>
                    <small class="char-counter help-block">
                      <span class="char-counter-output" id="discount_comment2_counter_output"></span>
                      <span class="char-counter-notification" id="discount_comment2_counter_notification"></span>
                    </small>
                  </div>

                  <div class="col-xs-12">
                    <label for="discount_comment3">Third Comment</label>
                    <textarea name="discount_comment3"
                              id="discount_comment3"><?= $data['discount_comment3'] ?></textarea>
                    <small class="char-counter help-block">
                      <span class="char-counter-output" id="discount_comment3_counter_output"></span>
                      <span class="char-counter-notification" id="discount_comment3_counter_notification"></span>
                    </small>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-12 text-center">
      <input type="button" id="submit" class="button" style="width: 150px;" value="Save"/>
    </div>
  </div>

</form>
<script src="<?= _A_::$app->router()->UrlTo('views/js/char-counter.jquery.min.js'); ?>"></script>
<script src="<?= _A_::$app->router()->UrlTo('views/js/formsimple/form.min.js'); ?>"></script>
