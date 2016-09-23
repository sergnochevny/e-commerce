<div class="ui-widget-overlay" id="wait_loader">
    <i class="fa fa-spinner fa-pulse fa-4x"></i>
</div>
<div class="row">
    <?php if (isset($warning)) { ?>
        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php foreach ($warning as $msg) {
                echo $msg . '<br/>';
            } ?>
        </div>
    <?php }
    if (isset($error)) { ?>
        <div class="col-xs-12 alert-danger danger" style="display: none;">
            <?php foreach ($error as $msg) {
                echo $msg . '<br/>';
            } ?>
        </div>
    <?php } ?>
</div>
<form method="POST" id="discount" action="<?= $action; ?>" class="col-md-12">
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <div class="row">

                    <div class="form-row">

                        <div class="col-md-4">
                            <label class="required_field">Promotion <i class="fa fa-question-circle" data-promotion
                                                                       href="#promotion"></i></label>
                        </div>
                        <div class="col-md-8">
                            <select name="iType" class="input-text">
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

                        <div class="col-md-4">
                            <label for="coupon_code">
                                Coupon Code <i data-promotion href="#coupon_code" class="fa fa-question-circle"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="coupon_code" id="coupon_code"
                                           value="<?= $data['coupon_code'] ?>" class="input-text"
                                           onkeyup="toggleCouponCode(true);">
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size: 10px; margin-top: 7px" for="generate_code">
                                        <input type="checkbox" name="generate_code" id="generate_code"
                                               onclick="toggleCouponCode(true);" value="1"
                                            <?= (isset($data['generate_code']) && $data['generate_code'] == '1') ? 'checked' : '' ?>
                                               class="input-checkbox">
                                        Generate Coupon Code for me.</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="required_field" for="discount_amount">
                                Discount details <i data-promotion href="#discount_details" class="fa fa-question-circle"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="discount_amount"
                                           value="<?= $data['discount_amount'] ?>" id="discount_amount"
                                           class="input-text ">
                                </div>
                                <div class="col-md-2">
                                    <select name="iAmntType" style="padding-left: 5px">
                                        <option value="1" <?= ($data['discount_amount_type'] == '1')?'selected':''?>>
                                            $
                                        </option>
                                        <option value="2" <?= ($data['discount_amount_type'] == '2')?'selected':''?>>
                                            %
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="iDscntType" id="iDscntType" onChange="toggleDiscountType(true);">
                                        <option value="0" <?= ($data['discount_type'] == '0')?'selected':''?>>
                                            Select
                                        </option>
                                        <option value="1" <?= ($data['discount_type'] == '1')?'selected':''?>>
                                            Sub total
                                        </option>
                                        <option value="2" <?= ($data['discount_type'] == '2')?'selected':''?>>
                                            Shipping
                                        </option>
                                        <option value="3" <?= ($data['discount_type'] == '3')?'selected':''?>>
                                            Total (inc shipping and handling)
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="required_field" data-promotion for="restrictions">
                                Restrictions <i data-promotion href="#discount_details" class="fa fa-question-circle"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="restrictions" value="<?= $data['required_amount'] ?>" class="input-text ">
                                </div>
                                <div class="col-md-8">
                                    <select name="iReqType">
                                        <option value="0" <?= ($data['required_type'] == '0')?'selected':''?>>
                                            Select
                                        </option>
                                        <option value="1" <?= ($data['required_type'] == '1')?'selected':''?>>
                                            Total purchases
                                        </option>
                                        <option value="2" <?= ($data['required_type'] == '2')?'selected':''?>>
                                            Total dollar amount
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="required_field" for="">
                                Users type <i class="fa fa-question-circle" data-promotion href="#users"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <label style="font-size: 12px;">
                                <?= $data['users_check'] == "1" ? '<input type="radio" id="users_check1" name="users_check" value="1" class="input-checkbox" checked="checked" onclick="toggleUsers();">' : '<input type="radio" id="users_check1" name="users_check" value="1" class="input-checkbox" onclick="toggleUsers();">'; ?>
                                All users
                            </label>
                            <label style="font-size: 12px;">
                                <?= $data['users_check'] == "2" ? '<input type="radio" id="users_check2" name="users_check" value="2" class="input-checkbox" checked="checked" onclick="toggleUsers();">' : '<input type="radio" id="users_check2" name="users_check" value="2" class="input-checkbox" onclick="toggleUsers();">'; ?>
                                All new users
                            </label>
                            <label style="font-size: 12px;">
                                <?= $data['users_check'] == "3" ? '<input type="radio" id="users_check3" name="users_check" value="3" class="input-checkbox" checked="checked" onclick="toggleUsers();">' : '<input type="radio" id="users_check3" name="users_check" value="3" class="input-checkbox" onclick="toggleUsers();">'; ?>
                                All registered users
                            </label>
                            <label style="font-size: 12px;">
                                <?= $data['users_check'] == "4" ? '<input type="radio" id="users_check4" name="users_check" value="4" class="input-checkbox" checked="checked" onclick="toggleUsers();">' : '<input type="radio" id="users_check4" name="users_check" value="4" class="input-checkbox" onclick="toggleUsers();">'; ?>
                                All selected users (i.e. use the users selected below)
                            </label>
                            <?= isset($data['users'])?$data['users']:'';?>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col-md-4">
                            <label class="required_field" for="">Fabrics <i class="fa fa-question-circle" data-promotion
                                                                            href="#fabrics"></i></label>
                        </div>
                        <div class="col-md-8">
                            <label for="">
                                <?= $data['sel_fabrics'] == "1" ? '<input type="radio" name="sel_fabrics" id="sel_fabrics1" value="1" class="input-checkbox" checked  onclick="toggleDetails();">' : '<input type="radio" name="sel_fabrics" id="sel_fabrics1" value="1" class="input-checkbox"  onclick="toggleDetails();">'; ?>
                                All fabrics
                            </label>
                            <label for="">
                                <?= $data['sel_fabrics'] == "2" ? '<input type="radio" name="sel_fabrics" id="sel_fabrics2" value="2" class="input-checkbox" checked  onclick="toggleDetails();">' : '<input type="radio" name="sel_fabrics" id="sel_fabrics2" value="2" class="input-checkbox"  onclick="toggleDetails();">'; ?>
                                All selected fabrics (i.e. use the fabrics selected below)
                            </label>
                            <?= isset($data['filter_products'])?$data['filter_products']:'';?>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col-md-4">
                            <label for="">Allow multiple <i class="fa fa-question-circle" data-promotion
                                                            href="#allow_multiple"></i></label>
                        </div>
                        <div class="col-md-8">
                            <?= $data['allow_multiple'] == "1" ? '<input type="checkbox"  value="1" name="allow_multiple" id="allow_multiple" checked class="input-checkbox">' : '<input type="checkbox" name="allow_multiple"  id="allow_multiple" value="1" class="input-checkbox">'; ?>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="">Start Date <i class="fa fa-question-circle" data-promotion
                                                        href="#start_date"></i></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="start_date" id="dateFrom" value="<?= $data['date_start'] ?>"
                                   class="input-text ">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="">End Date <i class="fa fa-question-circle" data-promotion href="#end_date"></i></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="date_end" value="<?= $data['date_end'] ?>"
                                   id="dateTo" class="input-text ">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="">Enabled <i class="fa fa-question-circle" data-promotion=""
                                                     href="#enabled"></i></label>
                        </div>
                        <div class="col-md-8">
                            <?= $data['enabled'] == "1" ? '<input type="checkbox"  value="1" name="enabled" checked="checked" class="input-checkbox">' : '<input type="checkbox"  value="1" name="enabled" class="input-checkbox">'; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="">Disable sale countdown <i class="fa fa-question-circle" data-promotion
                                                                    href="#disable_sale_countdown"></i></label>
                        </div>
                        <div class="col-md-8">
                            <?= $data['countdown'] == "1" ? '<input type="checkbox"  value="1" name="countdown" checked class="input-checkbox">' : '<input type="checkbox"  value="1" name="countdown" class="input-checkbox">'; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="">Comment 1 (200 char max)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="discount_comment1"
                                   value='<?= $data['discount_comment1'] ?>' class="input-text ">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="">Comment 2 (200 char max)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="discount_comment1"
                                   value='<?= $data['discount_comment2'] ?>' class="input-text ">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="">Comment 3 (200 char max)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="discount_comment1"
                                   value='<?= $data['discount_comment3'] ?>' class="input-text ">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <input type="submit" value="Update" name="login" class="button"
                                   style="width: 150px;">
                            <div class="results" style="color: red;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= _A_::$app->router()->UrlTo('views/js/discount/form.js'); ?>"></script>