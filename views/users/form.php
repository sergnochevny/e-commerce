<form id="user_form" action="<?= $action?>" method="post">

    <h1 class="page-title"><?= $form_title ?></h1>

    <?php
    if (isset($warning)) {
        ?>
        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php
            foreach ($warning as $msg) {
                echo '<span>' . $msg . '</span>';
            }
            ?>
        </div>
        <?php
    }
    ?>
    <?php
    if (isset($error)) {
        ?>
        <div class="col-xs-12 alert-danger danger" style="display: none;">
            <?php
            foreach ($error as $msg) {
                echo $msg;
            }
            ?>
        </div>
        <?php
    }
    ?>
    <div class="col-sm-12">
        <hr>
        <h3><b>LOGIN</b></h3>
        <hr/>
    </div>
    <div class="col-sm-12 registr-form-wrap">
        <div class="form-row">
            <label class="required_field"><strong>Email Address:</strong></label>
            <input type="text" name="email" value="<?= $data['email'] ?>"
                   class="input-text ">
        </div>

        <div class="form-row">
            <label><strong>Password:</strong></label>
            <input type="password" name="create_password"
                   class="input-text ">
            <label><strong>Confirm Password:</strong></label>
            <input type="password" name="confirm_password"
                   class="input-text ">
        </div>

        <div style="width: 100%;">
            <hr>
            <h4><b>BILLING INFORMATION</b></h4>
            <hr/>
        </div>

        <div class="form-row">
            <label class="required_field"><strong>First Name:</strong></label>
            <input type="text" name="first_name" value="<?= $data['bill_firstname'] ?>"
                   class="input-text ">
            <label class="required_field"><strong>Last Name:</strong></label>
            <input type="text" name="last_name" value="<?= $data['bill_lastname'] ?>"
                   class="input-text ">

            <label><strong>Organization:</strong></label>
            <input type="text" name="organization" value="<?= $data['bill_organization'] ?>"
                   class="input-text ">
        </div>

        <div class="form-row">
            <label class="required_field"><strong> Address:</strong></label>
            <input type="text" name="address" value="<?= $data['bill_address1'] ?>"
                   class="input-text ">
            <input type="text" name="address2" value="<?= $data['bill_address2'] ?>"
                   class="input-text ">
        </div>

        <div class="form-row">
            <label class="required_field"><strong> Country:</strong></label>
            <select name="country" value="<?= $data['bill_country'] ?>" class="input-text ">
                <option <?= (isset($data['bill_country']) && !empty($data['bill_country']{0}))?'':'selected'?> disabled>Select Country</option>
                <?= isset($data['bill_list_countries'] )?$data['bill_list_countries']:''?>
            </select>

            <label><strong> Province/State:</strong></label>
            <select name="province" value="<?= $data['bill_province'] ?>" class="input-text ">
                <option <?= (isset($data['bill_province']) && !empty($data['bill_province']{0}))?'':'selected'?> disabled>Select Province</option>
                <?= isset($data['bill_list_province'] )?$data['bill_list_province']:''?>
            </select>

            <label><strong> City:</strong></label>
            <input type="text" name="city" value="<?= $data['bill_city'] ?>"
                   class="input-text ">

            <label class="required_field"><strong> Postal/Zip Code:</strong></label>
            <input type="text" name="zip" value="<?= $data['bill_postal'] ?>"
                   class="input-text ">
        </div>

        <div class="form-row">
            <label class="required_field"><strong> Telephone:</strong></label>
            <input type="text" name="telephone" value="<?= $data['bill_phone'] ?>"
                   class="input-text ">

            <label><strong> Fax:</strong></label>
            <input type="text" name="fax" value="<?= $data['bill_fax'] ?>"
                   class="input-text ">

            <label><strong> Email:</strong></label>
            <input type="text" name="bil_email" value="<?= $data['bill_email'] ?>"
                   class="input-text ">
        </div>

        <div style="width: 100%;">
            <hr>
            <h4 class="form-wrap-title"><b>SHIPPING INFORMATION</b></h4>
            <hr/>
        </div>

        <div class="form-row">
            <label class="required_field"><strong> First Name:</strong></label>
            <input type="text" name="s_first_name" value="<?= $data['ship_firstname'] ?>"
                   class="input-text ">

            <label class="required_field"><strong> Last Name:</strong></label>
            <input type="text" name="s_last_name" value="<?= $data['ship_lastname'] ?>"
                   class="input-text ">

            <label><strong> Organization:</strong></label>
            <input type="text" name="s_organization"
                   value="<?= $data['ship_organization'] ?>"
                   class="input-text ">

            <label>
                <strong>Same as Billing:</strong>
                <input type="checkbox" name="Same_as_billing" <?= isset($data['Same_as_billing']) ? 'checked':''?> value="1"  class="input-checkbox">
            </label>
        </div>

        <div class="form-row">
            <label><strong> Telephone:</strong></label>
            <input type="text" name="s_telephone" value="<?= $data['ship_phone'] ?>"
                   class="input-text ">

            <label><strong> Fax:</strong></label>
            <input type="text" name="s_fax" value="<?= $data['ship_fax'] ?>"
                   class="input-text ">

            <label><strong> Email:</strong></label>
            <input type="text" name="s_email" value="<?= $data['ship_email'] ?>"
                   class="input-text ">
        </div>

        <div class="form-row">
            <label class="required_field"><strong>Address:</strong></label>
            <input type="text" name="s_address" value="<?= $data['ship_address1'] ?>"
                   class="input-text ">

            <input type="text" name="s_address2" value="<?= $data['ship_address2'] ?>"
                   class="input-text ">

            <label class="required_field"><strong> Country:</strong></label>
            <select name="s_country" value="<?= $data['ship_country'] ?>" class="input-text ">
                <option <?= (isset($data['ship_country']) && !empty($data['ship_country']{0}))?'':'selected'?> disabled>Select Country</option>
                <?= isset($data['ship_list_countries'] )?$data['ship_list_countries']:''?>
            </select>

            <label><strong> Province/State:</strong></label>
            <select name="s_state" value="<?= $data['ship_province'] ?>" class="input-text ">
                <option <?= (isset($data['ship_province']) && !empty($data['ship_province']{0}))?'':'selected'?> disabled>Select Province</option>
                <?= isset($data['ship_list_province'] )?$data['ship_list_province']:''?>
            </select>

            <label><strong> City:</strong></label>
            <input type="text" name="s_city" value="<?= $data['ship_city'] ?>"
                   class="input-text ">

            <label class="required_field"><strong> Postal/Zip Code:</strong></label>
            <input type="text" name="s_zip" value="<?= $data['ship_postal'] ?>"
                   class="input-text ">
        </div>

        <div class="text-center" style="width: 100%;">
            <input type="submit" value="SAVE" class="button"/>
        </div>
    </div>
</form>
<input type="hidden" id="base_url" value="<?= _A_::$app->router()->UrlTo('/')?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/users/form.js'); ?>' type="text/javascript"></script>