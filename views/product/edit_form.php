<form method="POST" id="product" action="<?= $action_url; ?>" class="enquiry-form ">
    <div>
        <p class="form-row">
            <?php
            $opt['pid'] = _A_::$app->get('p_id');
            if (isset($warning)) { ?>
        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php foreach ($warning as $msg) { ?>
                <?= $msg . "<br>"; ?>
            <?php } ?>
        </div>
        <?php }
        if (isset($error)) { ?>
            <div class="col-xs-12 alert-danger danger" style="display: none;">
                <?php foreach ($error as $msg) { ?>
                    <?= $msg . "<br>"; ?>
                <?php } ?>
            </div>
        <?php } ?>
        </p>
    </div>
    <div class="col-1">
        <p class="form-row">
            <label class="required_field"><strong>Product name:</strong></label>
            <input type="text" name="p_name" value="<?= $data['Product_name']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Product number:</strong></label>
            <input type="text" name="product_num" value="<?= $data['Product_number']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Meta Description:</strong></label>
            <input type="text" name="desc" placeholder="<?= $data['Short_description']; ?>"
                <?php if (!empty($data['metadescription'])) {
                    echo 'value="' . $data['metadescription'] . '"';
                }; ?>
                   class="input-text ">

        </p>

        <p class="form-row">
            <label><strong>Meta Keywords:</strong></label>
            <input type="text" name="mkey" value="<?= $data['Meta_Keywords']; ?>" class="input-text ">
        </p>
        <hr/>
        <p class="form-row">
            <label><strong>Default category: Brunschwig & Fils</strong></label>
        </p>

        <div class="form-row" data-role="dialog">
            <label><strong>Categories:</strong></label>
            <select multiple="" name="categori[]" style="height:85px;">
                <?= $data['sd_cat']; ?>
            </select>
        </div>
        <p class="form-row">
            <ul>
                <?= $data['categories']; ?>
            </ul>
        </p>

        <p class="form-row">
            <label><strong>Width:</strong></label>
            <input type="text" name="width" value="<?= $data['Width']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label>
                <strong>Piece:</strong>
                <?php
                if (isset($data['piece']) && ($data['piece'] == "1")) {
                    echo '<input type="checkbox" checked="checked" value="1" name="piece" class="input-checkbox">';
                } else {
                    echo '<input type="checkbox" name="piece" value="1" class="input-checkbox">';
                }
                ?>
            </label>
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Price:</strong></label>
            <input type="text" name="p_yard" value="<?= $data['Price_Yard']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label>
                <strong>Hide regular price:</strong>
                <?php
                if (isset($data['visible']) && ($data['visible'] == "1")) {
                    echo '<input type="checkbox" checked="checked" value="1" name="hide_prise" class="input-checkbox">';
                } else {
                    echo '<input type="checkbox" name="hide_prise" value="1" class="input-checkbox">';
                }
                ?>
            </label>
        </p>

        <p class="form-row">
            <label><strong>Mfg. & Stock number:</strong></label>
            <input type="text" name="st_nom" value="<?= $data['Stock_number']; ?>" class="input-text ">
        </p>

        <hr/>
        <p class="form-row">
            <label><strong>Dimensions:</strong></label>
            <input type="text" name="dimens" value="<?= $data['Dimensions']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Current inventory:</strong></label>
            <input type="text" name="curret_in" value="<?= $data['Current_inventory']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label>
                <strong>Whole:</strong>
                <?php
                    if (isset($data['whole']) && ($data['whole'] == "1")) {
                        echo '<input type="checkbox" checked="checked" name="whole" value="1" class="input-checkbox">';
                    } else {
                        echo '<input type="checkbox" name="whole" value="1" class="input-checkbox">';
                    }
                ?>
            </label>
        </p>

        <p class="form-row">
            <label><strong>Weight:</strong></label>
            <select name="weight_cat">
                <option value="0" <?php if ($data['weight_id'] == "0") {
                    echo 'selected=""';
                } ?>>Use Category Weight
                </option>
                <option value="1" <?php if ($data['weight_id'] == "1") {
                    echo 'selected=""';
                } ?>>Light
                </option>
                <option value="2" <?php if ($data['weight_id'] == "2") {
                    echo 'selected=""';
                } ?>>Medium
                </option>
                <option value="3" <?php if ($data['weight_id'] == "3") {
                    echo 'selected=""';
                } ?>>Heavy
                </option>
            </select>
            <small style="color:#999;">
                <strong>NOTE:</strong> choosing any of Light, Medium, Heavy overrides the default weight for the category.
            </small>
        </p>
        <hr/>
        <p class="form-row">
            <label><strong>Manufacturer:</strong></label>
            <select name="manufacturer">
                <?= $data['Manufacturer']; ?>
            </select>
        </p>

        <p class="form-row">
            <label><strong>New Manufacturer:</strong></label>
            <input type="text"
                   name="New_Manufacturer" <?= isset($data['New_Manufacturer']) ? 'value="' . $data['New_Manufacturer'] . '"' : '' ?>
                   class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Colours: </strong></label>
            <select multiple="" name="colors[]" style="height:85px;">
                <?= $data['Colours']; ?>
            </select>
        </p>

        <p class="form-row">
            <label><strong>New Colour:</strong></label>
            <input type="text"
                   name="new_color" <?= isset($data['New_Colour']) ? 'value="' . $data['New_Colour'] . '"' : '' ?>
                   class="input-text ">
        </p>

    </div>
    <div class="col-2">
        <p class="form-row">
            <label><strong>Short description:</strong></label>
            <input type="text" value="<?= $data['Short_description']; ?>" name="short_desk" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Long description:</strong></label>
            <textarea class="input-text " cols="5" rows="2" name="Long_description">
                        <?= $data['Long_description']; ?>
                        </textarea>
        </p>
        <hr/>
        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $data['Related_fabric_1']; ?>" name="fabric_1" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $data['Related_fabric_2']; ?>" name="fabric_2" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $data['Related_fabric_3']; ?>" name="fabric_3" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $data['Related_fabric_4']; ?>" name="fabric_4" class="input-text ">
        </p>

        <p class="form-row">
            <label><strong>Related fabric #:</strong></label>
            <input type="text" value="<?= $data['Related_fabric_5']; ?>" name="fabric_5" class="input-text ">
        </p>
        <hr/>


        <div class="form-row">
            <label><strong>Main images:</strong></label>
            <div class="text-center">
                <div id="modify_images2">
                    <?php
                    echo $modify_images;
                    ?>
                    <br/>

                    <div class="clear"></div>
                </div>

            </div>
            <div class="clear"></div>
        </div>

        <div style="margin-top: 15px; width: 200px; height: 70px; margin-left: 125px;" class="s"
             style="display: block;">
            <div id="upload" class="apd" style="cursor: pointer;"><span>Upload file</span></div>
        </div>
        <small style="color:#999;">
            <strong>NOTE</strong>: Select a place, and then click "Upload file" to set the image there.
        </small>
        <hr/>
        <p class="form-row">
            <label>
                <strong>Pattern Types:</strong>
                <select multiple="" name="patterns[]" style="height:85px;">
                    <?= $data['Pattern_Type']; ?>
                </select>
            </label>
        </p>

        <p class="form-row">
            <label><strong>New Pattern Type:</strong>
                <input type="text"
                       name="new_pattern_type" <?= isset($data['New_Pattern']) ? 'value="' . $data['New_Pattern'] . '"' : '' ?>
                       class="input-text ">
            </label>
        </p>

        <hr/>
        <p>
            <label>
                <strong style="vertical-align: 3px">Best Textile:</strong>
                <?php
                if (isset($data['best']) && ($data['best'] == "1")) {
                    echo '<input type="checkbox" name="best" value="1" checked class="input-checkbox">';
                } else {
                    echo '<input type="checkbox" name="best" value="1" class="input-checkbox">';
                }
                ?>
            </label><br>
            <label>
                <strong style="vertical-align: 3px">Specials:</strong>
                <?php
                if (isset($data['Specials']) && ($data['Specials'] == "1")) {
                    echo '<input type="checkbox" checked="checked" name="special" value="1" class="input-checkbox">';
                } else {
                    echo '<input type="checkbox" name="special" value="1" class="input-checkbox">';
                }
                ?>
            </label><br>
            <label>
                <strong style="vertical-align: 3px">
                    Visible:
                    <?php
                        if (isset($data['pvisible']) && ($data['pvisible'] == "1")) {
                            echo '<input type="checkbox" checked="checked" name="vis" value="1" class="input-checkbox">';
                        } else {
                            echo '<input type="checkbox" name="vis" value="1" class="input-checkbox">';
                        }
                        ?>
            </label>
        </p>
    </div><!--col-2-->
    <div class="col-xs-12">
        <div class="text-center">
            <br/>
            <input type="submit" value="Save" class="button" style="width: 150px;">
            <br/>
        </div>
    </div>
</form>
<input type="hidden" id="product_upload_img" value="<?= _A_::$app->router()->UrlTo('product/upload_img', $opt); ?>">
<input type="hidden" id="image_modify" value="<?= _A_::$app->router()->UrlTo('image/modify', $opt); ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/product/edit_form.js'); ?>' type="text/javascript"></script>