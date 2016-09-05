<form id="edit_user_form" action="<?php echo $action?>" method="post">

    <h1 class="page-title"><?= $title ?></h1>

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
    <div class="col-1">
        <hr>
        LOGIN
        <hr/>
        <p class="form-row">
            <label class="required_field"><strong>Email Address:</strong></label>
            <input type="text" name="email" value="<?= $userInfo['email'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Password:</strong></label>
            <input type="password" name="create_password"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Confirm Password:</strong></label>
            <input type="password" name="confirm_password"
                   class="input-text ">
        </p>
        <hr>
        BILLING INFORMATION
        <hr/>
        <p class="form-row">
            <label class="required_field"><strong>First Name:</strong></label>
            <input type="text" name="first_name" value="<?= $userInfo['bill_firstname'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Last Name:</strong></label>
            <input type="text" name="last_name" value="<?= $userInfo['bill_lastname'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Organization:</strong></label>
            <input type="text" name="organization" value="<?= $userInfo['bill_organization'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> Address:</strong></label>
            <input type="text" name="address" value="<?= $userInfo['bill_address1'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <input type="text" name="address2" value="<?= $userInfo['bill_address2'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> Country:</strong></label>
            <select name="country" value="<?= $userInfo['bill_country'] ?>" class="input-text ">
                <option <?php echo (isset($userInfo['bill_country']) && !empty($userInfo['bill_country']{0}))?'':'selected'?> disabled>Select Country</option>
                <?php echo isset($userInfo['bill_list_countries'] )?$userInfo['bill_list_countries']:''?>
            </select>
        </p>

        <p class="form-row">
            <label><strong> Province/State:</strong></label>
            <select name="province" value="<?= $userInfo['bill_province'] ?>" class="input-text ">
                <option <?php echo (isset($userInfo['bill_province']) && !empty($userInfo['bill_province']{0}))?'':'selected'?> disabled>Select Province</option>
                <?php echo isset($userInfo['bill_list_province'] )?$userInfo['bill_list_province']:''?>
            </select>
        </p>

        <p class="form-row">
            <label><strong> City:</strong></label>
            <input type="text" name="city" value="<?= $userInfo['bill_city'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> Postal/Zip Code:</strong></label>
            <input type="text" name="zip" value="<?= $userInfo['bill_postal'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> Telephone:</strong></label>
            <input type="text" name="telephone" value="<?= $userInfo['bill_phone'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong> Fax:</strong></label>
            <input type="text" name="fax" value="<?= $userInfo['bill_fax'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong> Email:</strong></label>
            <input type="text" name="bil_email" value="<?= $userInfo['bill_email'] ?>"
                   class="input-text ">
        </p>
        <hr>
        SHIPPING INFORMATION
        <hr/>
        <p class="form-row">
            <label><strong>Same as Billing:</strong></label>
            <input type="checkbox" name="Same_as_billing" <?php echo isset($userInfo['Same_as_billing']) ? 'checked':''?> value="1"  class="input-checkbox">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> First Name:</strong></label>
            <input type="text" name="s_first_name" value="<?= $userInfo['ship_firstname'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> Last Name:</strong></label>
            <input type="text" name="s_last_name" value="<?= $userInfo['ship_lastname'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong> Organization:</strong></label>
            <input type="text" name="s_organization"
                   value="<?= $userInfo['ship_organization'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Address:</strong></label>
            <input type="text" name="s_address" value="<?= $userInfo['ship_address1'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <input type="text" name="s_address2" value="<?= $userInfo['ship_address2'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> Country:</strong></label>
            <select name="s_country" value="<?= $userInfo['ship_country'] ?>" class="input-text ">
                <option <?php echo (isset($userInfo['ship_country']) && !empty($userInfo['ship_country']{0}))?'':'selected'?> disabled>Select Country</option>
                <?php echo isset($userInfo['ship_list_countries'] )?$userInfo['ship_list_countries']:''?>
            </select>
        </p>

        <p class="form-row">
            <label><strong> Province/State:</strong></label>
            <select name="s_state" value="<?= $userInfo['ship_province'] ?>" class="input-text ">
                <option <?php echo (isset($userInfo['ship_province']) && !empty($userInfo['ship_province']{0}))?'':'selected'?> disabled>Select Province</option>
                <?php echo isset($userInfo['ship_list_province'] )?$userInfo['ship_list_province']:''?>
            </select>
        </p>

        <p class="form-row">
            <label><strong> City:</strong></label>
            <input type="text" name="s_city" value="<?= $userInfo['ship_city'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong> Postal/Zip Code:</strong></label>
            <input type="text" name="s_zip" value="<?= $userInfo['ship_postal'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong> Telephone:</strong></label>
            <input type="text" name="s_telephone" value="<?= $userInfo['ship_phone'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong> Fax:</strong></label>
            <input type="text" name="s_fax" value="<?= $userInfo['ship_fax'] ?>"
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong> Email:</strong></label>
            <input type="text" name="s_email" value="<?= $userInfo['ship_email'] ?>"
                   class="input-text ">
        </p>
        <br><br>
        <center>
            <input type="submit" value="SAVE USER DATA" class="button"/>
        </center>
    </div>
</form>
<script type="text/javascript">
    (function($){

        var base_url = '<?= $base_url?>';

        $("#edit_user_form").on('submit',
            function(event){
                event.preventDefault();
                var url = $(this).attr('action');
                $.post(
                    url,
                    $(this).serialize(),
                    function(data){
                        $("#user_form").html(data);
                        if ($('.danger').length>0){
                            $('.danger').css('display', 'block');
                            $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
                            setTimeout(function () {
                                $('.danger').css('display', 'none');
                            }, 8000);
                        }
                    }
                )
            }
        );

        $("#edit_user_form [name=country]").on('change',
            function (event) {
                event.preventDefault();
                var url = base_url + '/get_province_list';
                var country = $(this).val();
                $.get(
                    url,
                    {country: country},
                    function (data) {
                        $('select[name=province]').html(data);
                    }
                )
            }
        );

        $("#edit_user_form [name=s_country]").on('change',
            function (event) {
                event.preventDefault();
                var url = base_url + '/get_province_list';
                var country = $(this).val();
                $.get(
                    url,
                    {country: country},
                    function (data) {
                        $('select[name=s_state]').html(data);
                    }
                )
            }
        );

    })(jQuery);
</script>
