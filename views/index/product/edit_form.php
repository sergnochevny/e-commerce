<form method="POST" id="product" action="<?php echo $action_url;?>" class="enquiry-form ">
    <div>
        <p class="form-row">
        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php
            if (isset($warning)) {
                foreach ($warning as $msg) {
                    echo $msg . "<br>";
                }
            }
            ?>
        </div>
        <div class="col-xs-12 alert-danger danger" style="display: none;">
            <?php
            if (isset($error)) {
                foreach ($error as $msg) {
                    echo $msg . "<br>";
                }
            }
            ?>
        </div>
        </p>
    </div>
    <div class="col-1">
        <p class="form-row">
            <label class="required_field"><strong>Product name:</strong></label>
            <input type="text" name="p_name" value="<?= $userInfo['Product_name']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Product number:</strong></label>
            <input type="text" name="product_num" value="<?= $userInfo['Product_number']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Meta Description:</strong></label>
            <input type="text" name="desc" placeholder="<?= $userInfo['Short_description']; ?>"
                <?php if (!empty($userInfo['metadescription'])) {
                    echo 'value="' . $userInfo['metadescription'] . '"';
                }; ?>
                   class="input-text ">

        </p>

        <p class="form-row">
            <label><strong>Meta Keywords:</strong></label>
            <input type="text" name="mkey" value="<?= $userInfo['Meta_Keywords']; ?>" class="input-text ">
        </p>
        <hr/>
        <p class="form-row">
            <label><strong>Default category: Brunschwig & Fils</strong></label>
        </p>

        <p class="form-row">
            <label><strong>Categories:</strong></label>
            <select multiple="" name="categori[]" style="height:85px;">
                <?= $userInfo['sd_cat']; ?>
            </select>

        </p>

        <p class="form-row">
            <label><strong>Width:</strong></label>
            <input type="text" name="width" value="<?= $userInfo['Width']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Piece:</strong></label>
            <?php
            if (isset($userInfo['piece']) && ($userInfo['piece'] == "1")) {
                echo '<input type="checkbox" checked="checked" value="1" name="piece" class="input-checkbox">';
            } else {
                echo '<input type="checkbox" name="piece" value="1" class="input-checkbox">';
            }
            ?>
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Price:</strong></label>
            <input type="text" name="p_yard" value="<?= $userInfo['Price_Yard']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Hide regular price:</strong></label>
            <?php
            if (isset($userInfo['visible']) && ($userInfo['visible'] == "1")) {
                echo '<input type="checkbox" checked="checked" value="1" name="hide_prise" class="input-checkbox">';
            } else {
                echo '<input type="checkbox" name="hide_prise" value="1" class="input-checkbox">';
            }
            ?>
        </p>

        <p class="form-row">
            <label><strong>Mfg. & Stock number:</strong></label>
            <input type="text" name="st_nom" value="<?= $userInfo['Stock_number']; ?>" class="input-text ">
        </p>

        <hr/>
        <p class="form-row">
            <label><strong>Dimensions:</strong></label>
            <input type="text" name="dimens" value="<?= $userInfo['Dimensions']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Current inventory:</strong></label>
            <input type="text" name="curret_in" value="<?= $userInfo['Current_inventory']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Whole:</strong></label>
            <?php
            if ( isset($userInfo['whole']) && ($userInfo['whole'] == "1")) {
                echo '<input type="checkbox" checked="checked" name="whole" value="1" class="input-checkbox">';
            } else {
                echo '<input type="checkbox" name="whole" value="1" class="input-checkbox">';
            }
            ?>
        </p>

        <p class="form-row">
            <label><strong>Weight:</strong></label>
            <select name="weight_cat">
                <option value="0" <?php if ($userInfo['weight_id'] == "0") {
                    echo 'selected=""';
                } ?>>Use Category Weight
                </option>
                <option value="1" <?php if ($userInfo['weight_id'] == "1") {
                    echo 'selected=""';
                } ?>>Light
                </option>
                <option value="2" <?php if ($userInfo['weight_id'] == "2") {
                    echo 'selected=""';
                } ?>>Medium
                </option>
                <option value="3" <?php if ($userInfo['weight_id'] == "3") {
                    echo 'selected=""';
                } ?>>Heavy
                </option>
            </select>
            <small><strong>NOTE:</strong> choosing any of Light, Medium, Heavy overrides the default weight for the
                category.
            </small>
        </p>
        <hr/>
        <p class="form-row">
            <label><strong>Manufacturer:</strong></label>
            <select name="manufacturer">
                <?= $userInfo['Manufacturer']; ?>
            </select>
        </p>

        <p class="form-row">
            <label><strong>New Manufacturer:</strong></label>
            <input type="text"
                   name="New_Manufacturer" <?php echo isset($userInfo['New_Manufacturer']) ? 'value="' . $userInfo['New_Manufacturer'] . '"' : '' ?>
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Colours: </strong></label>
            <select multiple="" name="colors[]" style="height:85px;">
                <?= $userInfo['Colours']; ?>
            </select>
        </p>

        <p class="form-row">
            <label><strong>New Colour:</strong></label>
            <input type="text"
                   name="new_color" <?php echo isset($userInfo['New_Colour']) ? 'value="' . $userInfo['New_Colour'] . '"' : '' ?>
                   class="input-text ">
        </p>

    </div>
    <div class="col-2">
        <p class="form-row">
            <label><strong>Short description:</strong></label>
            <input type="text" value="<?= $userInfo['Short_description']; ?>" name="short_desk" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Long description:</strong></label>
						<textarea class="input-text " cols="5" rows="2" name="Long_description">
                        <?= $userInfo['Long_description']; ?>
                        </textarea>
        </p>
        <hr/>
        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $userInfo['Related_fabric_1']; ?>" name="fabric_1" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $userInfo['Related_fabric_2']; ?>" name="fabric_2" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $userInfo['Related_fabric_3']; ?>" name="fabric_3" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $userInfo['Related_fabric_4']; ?>" name="fabric_4" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $userInfo['Related_fabric_5']; ?>" name="fabric_5" class="input-text ">
        </p>
        <hr/>


        <div class="form-row">
            <label><strong>Main images:</strong></label>
            <center>
                <div id="modify_images2">
                    <?php
                    echo $modify_images;
                    ?>
                    <br/>

                    <div class="clear"></div>
                </div>

            </center>
            <div class="clear"></div>
        </div>

        <div style="margin-top: 15px; width: 200px; height: 70px; margin-left: 125px;" class="s" style="display: block;">
            <div id="upload" class="apd" style="cursor: pointer;"><span>Upload file</span></div>
        </div>
        <small>
            <strong>NOTE</strong>: Select a place, and then click "Upload file" to set the image there.
        </small>
        <hr/>
        <p class="form-row">
            <label><strong>Pattern Types:</strong></label>
            <select multiple="" name="patterns[]" style="height:85px;">
                <?= $userInfo['Pattern_Type']; ?>
            </select>
        </p>

        <p class="form-row">
            <label><strong>New Pattern Type:</strong></label>
            <input type="text"
                   name="new_pattern_type" <?php echo isset($userInfo['New_Pattern']) ? 'value="' . $userInfo['New_Pattern'] . '"' : '' ?>
                   class="input-text ">
        </p>

        <hr/>
        <p class="form-row">
            <label><strong>Best Textile:</strong></label>
            <?php
            if (isset($userInfo['best']) && ($userInfo['best'] == "1")) {
                echo '<input type="checkbox" name="best" value="1" checked class="input-checkbox">';
            } else {
                echo '<input type="checkbox" name="best" value="1" class="input-checkbox">';
            }
            ?>
        </p>
        <p class="form-row">
            <label><strong>Specials:</strong></label>
            <?php
            if ( isset($userInfo['Specials']) && ($userInfo['Specials'] == "1")) {
                echo '<input type="checkbox" checked="checked" name="special" value="1" class="input-checkbox">';
            } else {
                echo '<input type="checkbox" name="special" value="1" class="input-checkbox">';
            }
            ?>
        </p>
        <p class="form-row">
            <label><strong>Visible:</strong></label>
            <select name="vis">
                <?php
                if ($userInfo['pvisible'] == "1") {
                    echo '<option selected="" value="1">visible </option>
                        		<option value="0">invisible </option>';
                } else {
                    echo '<option selected="" value="0">invisible </option>
                        		<option value="1">visible  </option>';
                }
                ?>
            </select>
        </p>
    </div><!--col-2-->
    <div class="col-xs-12">
        <center>
            <br/>
            <input type="submit" value="Save" class="button" style="width: 150px;">
            <br/>
        </center>
    </div>
</form>
<script type="text/javascript">
    (function($){
        var btnUpload = $('#upload');
        var status1 = $('#status');
        new AjaxUpload(btnUpload, {
            action: function(){
                var idx = $('input[name=images]:checked').val();
                if (!idx) idx = 1;
                return 'upload_product_img?pid=<?php echo $_GET['produkt_id'];?>&idx='+idx
            },
            name: 'uploadfile',
            onSubmit: function (file, ext) {
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                    status.text('Error format');
                    return false;
                }
            },
            onComplete: function (file, response) {
                if (response === "success") {
                    $('#modify_images2').load('modify_images<?php echo '?produkt_id='.$_GET['produkt_id'];?>');
                }
            }
        });

        $('form#product').on('submit',
            function(event) {
                event.preventDefault();
                var msg = $(this).serialize();
                var url = $(this).attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: msg,
                    success: function (data) {
                        debugger;
                        $('#form_product').html(data);
                        $('.danger').css('display','block');
                        $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
                        setTimeout(function(){
                            $('.danger').css('display','none');
                        },8000);
                    },
                    error: function (xhr, str) {
                        alert('Error: ' + xhr.responseCode);
                    }
                });
            }
        );

    })(jQuery);
</script>