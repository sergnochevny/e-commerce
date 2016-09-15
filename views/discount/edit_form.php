<div class="ui-widget-overlay" id="wait_loader">
    <i class="fa fa-spinner fa-pulse fa-4x"></i>
</div>
    <!--<form action="edit_discounts_data?discount_id=id"  method="post">-->
<form method="POST" id="discount" action="<?php echo _A_::$app->router()->UrlTo('discount/edit_data',['discount_id'=>_A_::$app->get('discount_id')]);?>"
      class="enquiry-form ">
    <br/>
    <div class="form-row">
        <?php
        if (isset($warning)) {
            ?>
            <div class="col-xs-12 alert-success danger" style="display: none;">
                <?php
                foreach ($warning as $msg) {
                    echo $msg . '<br/>';
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
                    echo $msg . '<br/>';
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
    <br/>
    <div class="col-1">
        <div class="b_MODIFY_DISCOUNT_left form-row">
            <a class="required_field" data-promotion href="#promotion">Promotion</a></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <select name="iType">
                <option value="0" <?php if ($userInfo['promotion_type'] == 0) {
                    echo " SELECTED";
                } ?> >Select the promotion type
                </option>
                <option value="1" <?php if ($userInfo['promotion_type'] == 1) {
                    echo " SELECTED";
                } ?> >Any purchase
                </option>
                <option value="2" <?php if ($userInfo['promotion_type'] == 2) {
                    echo " SELECTED";
                } ?> >First purchase
                </option>
                <option value="3" <?php if ($userInfo['promotion_type'] == 3) {
                    echo " SELECTED";
                } ?> >Next purchase after the start date
                </option>
                <option value="4" <?php if ($userInfo['promotion_type'] == 4) {
                    echo " SELECTED";
                } ?> >Users account total
                </option>
                <option value="5" <?php if ($userInfo['promotion_type'] == 5) {
                    echo " SELECTED";
                } ?> >Users account total for last month
                </option>
            </select>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"><a data-promotion href="#coupon_code">Coupon Code</a>
        </div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="coupon_code" id="coupon_code" style="width: 200px;"
                   value="<?= $userInfo['coupon_code'] ?>" class="input-text" onkeyup="toggleCouponCode(true);">
            <input type="checkbox" name="generate_code"  id="generate_code"  onclick="toggleCouponCode(true);" value="1"
                   <?php echo (isset($userInfo['generate_code']) && $userInfo['generate_code'] == '1') ? 'checked' : '' ?> class="input-checkbox">
            <span style="font-size: 10px;">Generate Coupon Code for me.</span>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"><a  class="required_field"  data-promotion href="#discount_details">Discount
                details</a></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="discount_amount" style="width: 150px;"
                   value="<?= $userInfo['discount_amount'] ?>" class="input-text ">
            <select name="iAmntType" style="width: 75px;">
                <option value="1"<?php if ($userInfo['discount_amount_type'] == '1') {
                    echo "SELECTED";
                } ?> >$
                </option>
                <option value="2"<?php if ($userInfo['discount_amount_type'] == '2') {
                    echo "SELECTED";
                } ?> >%
                </option>
            </select>
            <span style="color: black; font-size: 10px;">off the</span>
            <select name="iDscntType" id="iDscntType" onChange="toggleDiscountType(true);"
                    style="width: 110px;">
                <option value="0"<?php if ($userInfo['discount_type'] == '0') {
                    echo " SELECTED";
                } ?>>Select
                </option>
                <option value="1"<?php if ($userInfo['discount_type'] == '1') {
                    echo " SELECTED";
                } ?>>Sub total
                </option>
                <option value="2"<?php if ($userInfo['discount_type'] == '2') {
                    echo " SELECTED";
                } ?>>Shipping
                </option>
                <!--<option value="3"<?php if ($userInfo['discount_type'] == '3') {
                    echo " SELECTED";
                } ?>>Total (inc shipping and handling)</option>-->
            </select>
        </div>
        <div id="l_ship" class="b_MODIFY_DISCOUNT_left form-row"  <?php echo ($userInfo['discount_type'] == '2')?'':'style="display: none;"'?>>
            <a class="required_field">Shipping</a>
        </div>
        <div id="f_ship" class="b_MODIFY_DISCOUNT_right form-row"  <?php echo ($userInfo['discount_type'] == '2')?'':'style="display: none;"'?>>
            <select name="shipping_type" id="iShippingType">
                <option value="0" <?php echo ($userInfo['shipping_type'] == "0")?'selected':''?>>Select Shipping Type</option>
                <option value="1" <?php echo ($userInfo['shipping_type'] == "1")?'selected':''?>>Both</option>
                <option value="2" <?php echo ($userInfo['shipping_type'] == "2")?'selected':''?>>Ground</option>
                <option value="3" <?php echo ($userInfo['shipping_type'] == "3")?'selected':''?>>Express</option>
            </select>

        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"><a  class="required_field" data-promotion href="#restrictions">Restrictions</a>
        </div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="restrictions" style="width: 150px;"
                   value="<?= $userInfo['required_amount'] ?>" class="input-text ">
            <select name="iReqType" style="width: 228px;">
                <option value="0"<?php if ($userInfo['required_type'] == '0') {
                    echo " SELECTED";
                } ?>>Select
                </option>
                <option value="1"<?php if ($userInfo['required_type'] == '1') {
                    echo " SELECTED";
                } ?>>Total purchases
                </option>
                <option value="2"<?php if ($userInfo['required_type'] == '2') {
                    echo " SELECTED";
                } ?>>Total dollar amount
                </option>
            </select>

        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['users_check'] == "1") {
                echo '<input type="radio" id="users_check1" name="users_check" value="1" class="input-checkbox" checked="checked" onclick="toggleUsers();">';
            } else {
                echo '<input type="radio" id="users_check1" name="users_check" value="1" class="input-checkbox" onclick="toggleUsers();">';
            }
            ?>
            <span style="font-size: 12px;">All users</span>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['users_check'] == "2") {
                echo '<input type="radio" id="users_check2" name="users_check" value="2" class="input-checkbox" checked="checked" onclick="toggleUsers();">';
            } else {
                echo '<input type="radio" id="users_check2" name="users_check" value="2" class="input-checkbox" onclick="toggleUsers();">';
            }
            ?>
            <span style="font-size: 12px;">All new users</span>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row">Users type</div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['users_check'] == "3") {
                echo '<input type="radio" id="users_check3" name="users_check" value="3" class="input-checkbox" checked="checked" onclick="toggleUsers();">';
            } else {
                echo '<input type="radio" id="users_check3" name="users_check" value="3" class="input-checkbox" onclick="toggleUsers();">';
            }
            ?>
            <span style="font-size: 12px;">All registered users</span>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['users_check'] == "4") {
                echo '<input type="radio" id="users_check4" name="users_check" value="4" class="input-checkbox" checked="checked" onclick="toggleUsers();">';
            } else {
                echo '<input type="radio" id="users_check4" name="users_check" value="4" class="input-checkbox" onclick="toggleUsers();">';
            }
            ?>
            <span style="font-size: 12px;">All selected users (i.e. use the users selected below)</span>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row" style="height:175px;">
            <div style="padding-top: 75px;"><a data-promotion href="#users">Users</a></div>
        </div>
        <div class="b_MODIFY_DISCOUNT_right form-row" style="height:175px;">
            <select id="users_list" name="users_list[]" size="10" multiple style="height: auto;">
                <?= $userInfo['users_list'] ?>
            </select>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['sel_fabrics'] == "1") {
                echo '<input type="radio" name="sel_fabrics" id="sel_fabrics1" value="1" class="input-checkbox" checked  onclick="toggleDetails();">';
            } else {
                echo '<input type="radio" name="sel_fabrics" id="sel_fabrics1" value="1" class="input-checkbox"  onclick="toggleDetails();">';
            }
            ?>
            <span style="font-size: 12px;">All fabrics</span>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['sel_fabrics'] == "2") {
                echo '<input type="radio" name="sel_fabrics" id="sel_fabrics2" value="2" class="input-checkbox" checked  onclick="toggleDetails();">';
            } else {
                echo '<input type="radio" name="sel_fabrics" id="sel_fabrics2" value="2" class="input-checkbox"  onclick="toggleDetails();">';
            }
            ?>
            <span style="font-size: 12px;">All selected fabrics (i.e. use the fabrics selected below)</span>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row" style="height:175px;">
            <div style="padding-top: 75px;"><a data-promotion href="#fabrics">Fabrics</a></div>
        </div>
        <div class="b_MODIFY_DISCOUNT_right form-row" style="height:175px;">
            <select id="fabric_list" name="fabric_list[]" size="5" style="height: 160px;" multiple>
                <?= $userInfo['fabric_list'] ?>
            </select>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row">
            <a data-promotion href="#allow_multiple">Allow multiple</a>
        </div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['allow_multiple'] == "1") {
                echo '<input type="checkbox"  value="1" name="allow_multiple" id="allow_multiple" checked class="input-checkbox">';
            } else {
                echo '<input type="checkbox" name="allow_multiple"  id="allow_multiple" value="1" class="input-checkbox">';
            }
            ?>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"><a class="required_field" data-promotion href="#start_date">Start Date</a></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="start_date" id="dateFrom"
                   value="<?= $userInfo['date_start'] ?>" class="input-text ">
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"><a class="required_field" data-promotion href="#end_date">End Date</a></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="date_end" value="<?= $userInfo['date_end'] ?>"
                   id="dateTo" class="input-text ">
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"><a data-promotion href="#enabled">Enabled</a></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['enabled'] == "1") {
                echo '<input type="checkbox"  value="1" name="enabled" checked="checked" class="input-checkbox">';
            } else {
                echo '<input type="checkbox"  value="1" name="enabled" class="input-checkbox">';
            }
            ?>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row"><a data-promotion href="#disable_sale_countdown">Disable
                sale countdown</a></div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <?php
            if ($userInfo['countdown'] == "1") {
                echo '<input type="checkbox"  value="1" name="countdown" checked class="input-checkbox">';
            } else {
                echo '<input type="checkbox"  value="1" name="countdown" class="input-checkbox">';
            }
            ?>
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row">Comment 1 (200 char max)</div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="discount_comment1"
                   value='<?= $userInfo['discount_comment1'] ?>' class="input-text ">
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row">Comment 2 (200 char max)</div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="discount_comment2"
                   value='<?= $userInfo['discount_comment2'] ?>' class="input-text ">
        </div>
        <div class="b_MODIFY_DISCOUNT_left form-row">Comment 3 (200 char max)</div>
        <div class="b_MODIFY_DISCOUNT_right form-row">
            <input type="text" name="discount_comment3"
                   value='<?= $userInfo['discount_comment3'] ?>' class="input-text ">
        </div>
        <br/><br/>
        <center>
            <input type="submit" value="Update" name="login" class="button"
                   style="width: 150px;">
            <br/>

            <div class="results" style="color: red;"></div>
        </center>
</form>

<script>
    (function($){
       
        $('#dateTo').datepicker({
            dateFormat: 'mm/dd/yy',
            onSelect: function (dateText, inst) {
                $('#dateFrom').datepicker('option', 'maxDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
            }
        });

        $('form#discount').on('submit',
            function (event) {
//            event.preventDefault();
//            var msg = $(this).serialize();
//            var url = $(this).attr('action');
                $('body').waitloader('show');
//            $.ajax({
//                type: 'POST',
//                url: url,
//                data: msg,
//                success: function (data) {
//                    $('#discount_form').html(data);
//                    $('.danger').css('display', 'block');
//                    $('body').waitloader('remove');
//                    $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
//                    setTimeout(function () {
//                        $('.danger').css('display', 'none');
//                    }, 8000);
//                },
//                error: function (xhr, str) {
//                    alert('Error: ' + xhr.responseCode);
//                }
//            });
            }
        );

        $(document).ready(
            function(){
                $('content').waitloader('remove');
                if ($('.danger').length > 0){
                    $('.danger').css('display', 'block');
                    $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
                    setTimeout(function () {
                        $('.danger').css('display', 'none');
                    }, 8000);
                }
            }
        );

    })(jQuery);

    function toggleDiscountType(enable){
        var dtlSlct = document.getElementById('iDscntType');
        var mlt = document.getElementById('allow_multiple');
        var fbtAll = document.getElementById('sel_fabrics1');
        var l_ship = document.getElementById('l_ship');
        var f_ship = document.getElementById('f_ship');

        if(dtlSlct.selectedIndex == 2){

            mlt.checked = true;
            fbtAll.checked = true;
            l_ship.style.display = '';
            f_ship.style.display = '';

            toggleFabrics();
        } else {
            l_ship.style.display = 'none';
            f_ship.style.display = 'none';
        }

        toggleDetailSelect(dtlSlct, false);

    }

    function toggleCouponCode(enable) {
        var txtCoupon = document.getElementById('coupon_code');
        var chckCoupon = document.getElementById('generate_code');
        var chckMlt = document.getElementById('allow_multiple');
        var fbtAll = document.getElementById('sel_fabrics1');
        var fbtSlct = document.getElementById('sel_fabrics2');

        //if the coupon code is entered or the generate the coupon code box is checked then we have to make the multiple box checked
        //this is because we are enforcing the system to make is so that all promotions with a coupon code are added to other deals
        //we also can not be doing the
        if ((txtCoupon.value.length > 0) || (chckCoupon.checked)) {
            chckMlt.checked = true;
            fbtAll.checked = true;

            toggleFabrics();
        }

    }

    function toggleDetailSelect(dtlSlct, disable){
        dtlSlct.disabled = disable;
    }

    function toggleFabrics(){
        var fl = document.getElementById('fabric_list');
        var sf1 = document.getElementById('sel_fabrics1');

        fl.disabled = sf1.checked;
    }

    function toggleDetails() {
        var fbtAll = document.getElementById('sel_fabrics1');
        var fbtSlct = document.getElementById('sel_fabrics2');
        var dtlSlct = document.getElementById('iDscntType');

        toggleFabrics();

        if (fbtSlct.checked) {
            dtlSlct.selectedIndex = 1;
        }

        toggleDiscountType(true);

    }

    function toggleUsers() {
        var ul = document.getElementById('users_list');
        var uc4= document.getElementById('users_check4');
        ul.disabled = !uc4.checked;
    }

    //    toggleDetails();
    //    toggleDiscountType(false);
    //    toggleCouponCode(false);

    var fl = document.getElementById('fabric_list');
    var sf1 = document.getElementById('sel_fabrics1');
    var ul = document.getElementById('users_list');
    var uc4= document.getElementById('users_check4');

    fl.disabled = sf1.checked;
    ul.disabled = !uc4.checked;

</script>
