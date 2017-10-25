<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>
<form method="POST" id="edit_form" action="<?= $action; ?>" class="col-xs-12 col-md-10 col-md-offset-1"
      xmlns="http://www.w3.org/1999/html">
  <div class="tabs col-xs-12">

    <div class="col-xs-12 tab">
      <div class="row">
        <ul class="tabNavigation">
          <li><a class="" data-tab_index="1" href="#first">System</a></li>
          <li><a class="" data-tab_index="2" href="#second">Shop</a></li>
          <li><a class="" data-tab_index="3" href="#third">Shop Widgets</a></li>
        </ul>
      </div>
    </div>

    <div class="tabs_content col-xs-12">
      <div class="col-xs-12">
        <div data-role="tab" class="row" id="first" style="display: none;">
          <div class="row">
            <div class="col-xs-12 text-center">
              <h3>System</h3>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12">
                  <label class="required_field">
                    Site Name
                  </label>
                  <i class="fa fa-question-circle" data-promotion="" href="#system_site_name"></i>
                  <div class="form-row">
                    <input type="text" name="system_site_name" class="input-text"
                           value="<?= $data['system_site_name']; ?>"/>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="form-row">
                    <label>
                      <input type="checkbox" name="system_enable_sef" value="1"
                        <?= (isset($data['system_enable_sef']) && $data['system_enable_sef'] == '1') ? 'checked' : '' ?>
                             class="input-checkbox">
                      Enable SEF
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#system_enable_sef"></i>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <label class="required_field">
                    Filter Limit Amount
                  </label>
                  <i class="fa fa-question-circle" data-promotion="" href="#system_filter_amount"></i>
                  <div class="form-row">
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
                </div>
                <div class="col-xs-12 col-sm-6">
                  <label class="required_field">
                    Captcha Relevant Time
                  </label>
                  <i class="fa fa-question-circle" data-promotion="" href="#system_captcha_time"></i>
                  <div class="form-row">
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
                </div>
                <div class="col-xs-12">
                  <label class="required_field">
                    System Information Email
                  </label>
                  <i class="fa fa-question-circle" data-promotion="" href="#system_info_email"></i>
                  <div class="form-row">
                    <input type="email" name="system_info_email" class="input-text"
                           value="<?= $data['system_info_email']; ?>"/>
                  </div>
                </div>
                <div class="col-xs-6">
                  <label>
                    <input type="checkbox" name="system_csv_use_gz" value="1"
                      <?= (isset($data['system_csv_use_gz']) && $data['system_csv_use_gz'] == '1') ? 'checked' : '' ?>
                           class="input-checkbox">
                    Export Users CSV, use gz compression
                  </label>
                  <i class="fa fa-question-circle" data-promotion="" href="#system_csv_use_gz"></i>
                </div>
                <div class="col-xs-6">
                  <label class="required_field">
                    Export Users CSV, fields delimiter
                  </label>
                  <i class="fa fa-question-circle" data-promotion="" href="#system_csv_fields_dlm"></i>
                  <div class="form-row">
                    <select name="system_csv_fields_dlm" class="input-text">
                      <option value="," <?= ($data['system_csv_fields_dlm'] == ',') ? 'selected' : ''; ?>>
                        , Comma
                      </option>
                      <option value=";" <?= ($data['system_csv_fields_dlm'] == ';') ? 'selected' : ''; ?>>
                        ; Semicolon
                      </option>
                      <option value="|" <?= ($data['system_csv_fields_dlm'] == '|') ? 'selected' : ''; ?>>
                        | Vertical Bar
                      </option>
                    </select>
                  </div>
                </div>

                <div class="col-xs-12">
                  <label class="required_field">
                    Export Users CSV fields
                  </label>
                  <i class="fa fa-question-circle" data-promotion="" href="#system_csv_fields"></i>
                  <small class="hint">(drag the field box and place it in
                    desired place or use the action spots)
                  </small>
                </div>
                <div data-csv_export_fields class="export-fields col-xs-12">
                  <div class="box">
                    <div class="col-xs-12 col-sm-6 col-sm-halfoffset-right">
                      <div class="col-xs-12">
                        <div class="row">
                          <label>Selected Fields</label>
                          <small class="hint">(that will be exported)</small>
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <div class="row">
                          <ul data-sortable class="sortable selected_fields">
                            <?php if(isset($data['system_csv_fields']) && is_array($data['system_csv_fields'])): ?>
                              <?php foreach($data['system_csv_fields'] as $field): ?>
                                <li class="sortable_item">
                                  <div class="col-xs-1 dd-action text-center">
                                    <div class="row">
                                      <i class="fa fa-2x fa-plus" data-append aria-hidden="true"></i>
                                      <i class="fa fa-2x fa-minus" data-remove aria-hidden="true"></i>
                                    </div>
                                  </div>
                                  <label class="dd-sortable">
                                    <div class="col-xs-1 text-center">
                                      <div class="row">
                                        <i class="fa fa-2x fa-arrows-v" aria-hidden="true"></i>
                                        <i class="fa fa-2x fa-long-arrow-left" aria-hidden="true"></i>
                                      </div>
                                    </div>
                                    <div class="col-xs-9">
                                      <div class="row field_name">
                                        <?= $field; ?>
                                      </div>
                                    </div>
                                  </label>
                                  <div class="col-xs-1 move-arrows pull-right text-right">
                                    <div class="row">
                                      <i data-move_up class="fa fa-arrow-up" aria-hidden="true"></i>
                                      <i data-move_down class="fa fa-arrow-down" aria-hidden="true"></i>
                                    </div>
                                  </div>
                                  <input type="checkbox" name="system_csv_fields[]"
                                         value="<?= $field; ?>" checked
                                         class="hidden csv_field input-checkbox">
                                  </input>
                                </li>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-sm-halfoffset-left">
                      <div class="col-xs-12">
                        <div class="row">
                          <label for="">Available Fields</label>
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <div class="row">
                          <ul data-sortable class="sortable available_fields">
                            <?php if(isset($data['system_csv_fields_avail']) && is_array($data['system_csv_fields_avail'])): ?>
                              <?php foreach($data['system_csv_fields_avail'] as $field): ?>
                                <li class="sortable_item">
                                  <div class="col-xs-1 dd-action text-center">
                                    <div class="row">
                                      <i class="fa fa-2x fa-plus" data-append aria-hidden="true"></i>
                                      <i class="fa fa-2x fa-minus" data-remove aria-hidden="true"></i>
                                    </div>
                                  </div>
                                  <label class="dd-sortable">
                                    <div class="col-xs-1 text-center">
                                      <div class="row">
                                        <i class="fa fa-2x fa-arrows-v" aria-hidden="true"></i>
                                        <i class="fa fa-2x fa-long-arrow-left hidden-xs" aria-hidden="true"></i>
                                      </div>
                                    </div>
                                    <div class="col-xs-9">
                                      <div class="row field_name">
                                        <?= $field; ?>
                                      </div>
                                    </div>
                                  </label>
                                  <div class="col-xs-1 move-arrows pull-right text-right hidden">
                                    <div class="row">
                                      <i data-move_up class="fa fa-arrow-up" aria-hidden="true"></i>
                                      <i data-move_down class="fa fa-arrow-down" aria-hidden="true"></i>
                                    </div>
                                  </div>
                                  <input type="checkbox" name="system_csv_fields[]"
                                         value="<?= $field; ?>" class="hidden csv_field input-checkbox">
                                  </input>
                                </li>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div data-role="tab" class="row" id="second" style="display: none;">
          <div class="row">
            <div class="col-xs-12 text-center">
              <h3>Shop</h3>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12 col-sm-6">
                  <div class="form-row">
                    <label>
                      <input type="checkbox" name="system_allow_sample_express_shipping" value="1"
                        <?= (isset($data['system_allow_sample_express_shipping']) && $data['system_allow_sample_express_shipping'] == '1') ? 'checked' : '' ?>
                             class="input-checkbox">
                      Allow Sample EXPRESS SHIPPING
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#system_allow_sample_express_shipping"></i>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <div class="form-row">
                    <label>
                      <input type="checkbox" name="system_hide_all_regular_prices" value="1"
                        <?= (isset($data['system_hide_all_regular_prices']) && $data['system_hide_all_regular_prices'] == '1') ? 'checked' : '' ?>
                             class="input-checkbox">
                      Hide all regular prices.
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#system_hide_all_regular_prices"></i>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      PayPal Business Account
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#paypal_business"></i>
                    <input type="email" name="paypal_business" class="input-text"
                           value="<?= $data['paypal_business']; ?>"/>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      PayPal proceed URI
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#paypal_url"></i>
                    <input type="url" name="paypal_url" class="input-text"
                           value="<?= $data['paypal_url']; ?>"/>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Handling
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_handling"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_handling" class="input-text"
                      value="<?= number_format($data['shop_rate_handling'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Roll
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_roll"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_roll" class="input-text"
                      value="<?= number_format($data['shop_rate_roll'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Express Light
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_express_light"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_express_light" class="input-text"
                      value="<?= number_format($data['shop_rate_express_light'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Express Medium
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_express_medium"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_express_medium" class="input-text"
                      value="<?= number_format($data['shop_rate_express_medium'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Express Heavy
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_express_heavy"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_express_heavy" class="input-text"
                      value="<?= number_format($data['shop_rate_express_heavy'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Ground Light
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_ground_light"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_ground_light" class="input-text"
                      value="<?= number_format($data['shop_rate_ground_light'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Ground Medium
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_ground_medium"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_ground_medium" class="input-text"
                      value="<?= number_format($data['shop_rate_ground_medium'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Rate Ground Heavy
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_ground_heavy"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_ground_heavy" class="input-text"
                      value="<?= number_format($data['shop_rate_ground_heavy'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Light Express Rate Multiplier
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_express_light_multiplier"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_express_light_multiplier" class="input-text"
                      value="<?= number_format($data['shop_rate_express_light_multiplier'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Medium Express Rate Multiplier
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_express_medium_multiplier"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_express_medium_multiplier" class="input-text"
                      value="<?= number_format($data['shop_rate_express_medium_multiplier'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Heavy Express Rate Multiplier
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_express_heavy_multiplier"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_express_heavy_multiplier" class="input-text"
                      value="<?= number_format($data['shop_rate_express_heavy_multiplier'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Light Ground Rate Multiplier
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_ground_light_multiplier"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_ground_light_multiplier" class="input-text"
                      value="<?= number_format($data['shop_rate_ground_light_multiplier'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Medium Ground Rate Multiplier
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_ground_medium_multiplier"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_ground_medium_multiplier" class="input-text"
                      value="<?= number_format($data['shop_rate_ground_medium_multiplier'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Heavy Ground Rate Multiplier
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_rate_ground_heavy_multiplier"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_rate_ground_heavy_multiplier" class="input-text"
                      value="<?= number_format($data['shop_rate_ground_heavy_multiplier'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Samples Express Shipping Price
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_samples_price_express_shipping"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_samples_price_express_shipping" class="input-text"
                      value="<?= number_format($data['shop_samples_price_express_shipping'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Samples Qty Multiple Min
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_samples_qty_multiple_min"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_samples_qty_multiple_min" class="input-text"
                      value="<?= number_format($data['shop_samples_qty_multiple_min'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Samples Qty Multiple Max
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_samples_qty_multiple_max"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_samples_qty_multiple_max" class="input-text"
                      value="<?= number_format($data['shop_samples_qty_multiple_max'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Samples Price Single
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_samples_price_single"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_samples_price_single" class="input-text"
                      value="<?= number_format($data['shop_samples_price_single'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Samples Price Multiple
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_samples_price_multiple"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_samples_price_multiple" class="input-text"
                      value="<?= number_format($data['shop_samples_price_multiple'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Samples Price Additional
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_samples_price_additional"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_samples_price_additional" class="input-text"
                      value="<?= number_format($data['shop_samples_price_additional'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Samples Price With Products
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_samples_price_with_products"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_samples_price_with_products" class="input-text"
                      value="<?= number_format($data['shop_samples_price_with_products'], 2, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Yrds for Multiplier
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_yrds_for_multiplier"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_yrds_for_multiplier" class="input-text"
                      value="<?= number_format($data['shop_yrds_for_multiplier'], 2, ".", ""); ?>"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div data-role="tab" class="row" id="third" style="display: none;">
          <div class="row">
            <div class="col-xs-12 text-center">
              <h3>Shop Wigets</h3>
            </div>
            <div class="col-xs-12">
              <div class="row">

                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Best Sellers amount items
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_bestsellers_amount"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_bestsellers_amount" class="input-text"
                      value="<?= number_format($data['shop_bestsellers_amount'], 0, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      Specials amount items
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_specials_amount"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_specials_amount" class="input-text"
                      value="<?= number_format($data['shop_specials_amount'], 0, ".", ""); ?>"/>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-row">
                    <label class="required_field">
                      "Under" amount items
                    </label>
                    <i class="fa fa-question-circle" data-promotion="" href="#shop_under_amount"></i>
                    <input
                      data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                      type="text"
                      name="shop_under_amount" class="input-text"
                      value="<?= number_format($data['shop_under_amount'], 0, ".", ""); ?>"/>
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
    <div class="col-xs-12 text-center offset-top">
      <input type="button" data-role="submit" id="submit" class="button" style="width: 150px;" value="Save"/>
    </div>
  </div>
  <input type="hidden" name="current_tab" value="<?= (isset($data['current_tab']) ? $data['current_tab'] : 1) ?>">
</form>
<script src="<?= _A_::$app->router()->UrlTo('js/char-counter.jquery.min.js'); ?>"></script>
<script src="<?= _A_::$app->router()->UrlTo('js/settings/form.min.js'); ?>"></script>
<script src="<?= _A_::$app->router()->UrlTo('js/formsimple/form.min.js'); ?>"></script>
