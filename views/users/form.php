<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>
<form id="edit_form" action="<?= $action ?>" method="post">
  <div class="col-md-push-2 col-md-8 col-xs-12">

    <div class="row">
      <div class="col-xs-12">
        <div class="form-row">
          <label class="required_field"><strong>Email Address:</strong></label>
          <input type="text" name="email" value="<?= $data['email'] ?>" class="input-text ">
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="form-row">
          <label><strong>Password:</strong></label>
          <input type="password" name="create_password" class="input-text ">
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="form-row">
          <label><strong>Confirm Password:</strong></label>
          <input type="password" name="confirm_password" class="input-text ">
        </div>
      </div>
    </div>

    <div class="col-xs-12">
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading">
            <b>BILLING INFORMATION</b>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong>First Name:</strong></label>
                  <input type="text" name="bill_firstname" value="<?= $data['bill_firstname'] ?>" class="input-text ">
                </div>
              </div>

              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong>Last Name:</strong></label>
                  <input type="text" name="bill_lastname" value="<?= $data['bill_lastname'] ?>" class="input-text ">
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-row">
                  <label><strong>Organization:</strong></label>
                  <input type="text" name="bill_organization" value="<?= $data['bill_organization'] ?>"
                         class="input-text ">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong> Address:</strong></label>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <input type="text" name="bill_address1" value="<?= $data['bill_address1'] ?>" class="input-text ">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <input type="text" name="bill_address2" value="<?= $data['bill_address2'] ?>" class="input-text ">
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong> Country:</strong></label>
                  <select data-change-province data-destination="bill_province" name="bill_country"
                          value="<?= $data['bill_country'] ?>" class="input-text ">
                    <?= isset($data['bill_list_countries']) ? $data['bill_list_countries'] : '' ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label><strong> Province/State:</strong></label>
                  <select name="bill_province" value="<?= $data['bill_province'] ?>" class="input-text ">
                    <?= isset($data['bill_list_province']) ? $data['bill_list_province'] : '' ?>
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label><strong> City:</strong></label>
                  <input type="text" name="bill_city" value="<?= $data['bill_city'] ?>" class="input-text ">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong> Postal/Zip Code:</strong></label>
                  <input type="text" name="bill_postal" value="<?= $data['bill_postal'] ?>" class="input-text ">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong> Telephone:</strong></label>
                  <input type="text" name="bill_phone" value="<?= $data['bill_phone'] ?>" class="input-text ">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label><strong> Fax:</strong></label>
                  <input type="text" name="bill_fax" value="<?= $data['bill_fax'] ?>" class="input-text ">
                </div>
              </div>
            </div>

            <div class="col-xs-12">
              <div class="row">
                <div class="form-row">
                  <label><strong> Email:</strong></label>
                  <input type="text" name="bill_email" value="<?= $data['bill_email'] ?>" class="input-text ">
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
      <div class="row">
        <div class="panel panel-default panel-toggle-settings">
          <div class="panel-heading">
            <div
              class="visible-md-inline-block visible-xs-inline-block visible-sm-inline-block visible-lg-inline-block">
              <label style="line-height: 1;">
                <strong><b>SHIPPING INFORMATION:</b> Same as Billing</strong>
                <input type="checkbox"
                       name="ship_as_billing" <?= isset($data['ship_as_billing']) ? 'checked' : '' ?>
                       value="1"
                       class="input-checkbox"
                       aria-controls="collapse">
              </label>
            </div>
          </div>
          <div id="collapse" class="panel-body panel-collapse collapse in">
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong> First Name:</strong></label>
                  <input type="text" name="ship_firstname" value="<?= $data['ship_firstname'] ?>" class="input-text ">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong> Last Name:</strong></label>
                  <input type="text" name="ship_lastname" value="<?= $data['ship_lastname'] ?>" class="input-text ">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12">
                <div class="form-row">
                  <label><strong> Organization:</strong></label>
                  <input type="text" name="ship_organization" value="<?= $data['ship_organization'] ?>"
                         class="input-text ">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong>Address:</strong></label>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <input type="text" name="ship_address1" value="<?= $data['ship_address1'] ?>" class="input-text ">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <input type="text" name="ship_address2" value="<?= $data['ship_address2'] ?>" class="input-text ">
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6 col-xs-12">
                <label class="required_field"><strong> Country:</strong></label>
                <div class="form-row">
                  <select data-change-province data-destination="ship_province" name="ship_country"
                          value="<?= $data['ship_country'] ?>" class="input-text ">
                    <?= isset($data['ship_list_countries']) ? $data['ship_list_countries'] : '' ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <label><strong> Province/State:</strong></label>
                <div class="form-row">
                  <select name="ship_province" value="<?= $data['ship_province'] ?>" class="input-text ">
                    <?= isset($data['ship_list_province']) ? $data['ship_list_province'] : '' ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label><strong> City:</strong></label>
                  <input type="text" name="ship_city" value="<?= $data['ship_city'] ?>" class="input-text ">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label class="required_field"><strong> Postal/Zip Code:</strong></label>
                  <input type="text" name="ship_postal" value="<?= $data['ship_postal'] ?>" class="input-text ">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label><strong> Telephone:</strong></label>
                  <input type="text" name="ship_phone" value="<?= $data['ship_phone'] ?>" class="input-text ">
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-row">
                  <label><strong> Fax:</strong></label>
                  <input type="text" name="ship_fax" value="<?= $data['ship_fax'] ?>" class="input-text ">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12">
                <div class="form-row">
                  <label><strong> Email:</strong></label>
                  <input type="text" name="ship_email" value="<?= $data['ship_email'] ?>" class="input-text ">
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="text-center">
          <input type="submit" value="SAVE" class="button"/>
        </div>
      </div>
    </div>
  </div>
</form>
<script src='<?= App::$app->router()->UrlTo('js/users/province.min.js'); ?>' type="text/javascript"></script>
<script src='<?= App::$app->router()->UrlTo('js/users/form.min.js'); ?>' type="text/javascript"></script>
<script src='<?= App::$app->router()->UrlTo('js/formsimple/form.min.js'); ?>' type="text/javascript"></script>
