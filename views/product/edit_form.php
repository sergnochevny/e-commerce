<form method="POST" id="product" action="<?= $action_url; ?>" class="enquiry-form ">
    <div>
        <div class="form-row">
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
    <div class="col-md-12">
        <div class="row">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-row">
                        <label class="required_field"><strong>Product name:</strong></label>
                        <input type="text" name="p_name" value="<?= $data['Product_name']; ?>" class="input-text ">
                    </div>

                    <div class="form-row">
                        <label class="required_field"><strong>Product number:</strong></label>
                        <input type="text" name="product_num" value="<?= $data['Product_number']; ?>" class="input-text ">
                    </div>

                    <div class="form-row">
                        <label><strong>Meta Description:</strong></label>
                        <input type="text" name="desc" placeholder="<?= $data['Short_description']; ?>"
                            <?php if (!empty($data['metadescription'])) {
                                echo 'value="' . $data['metadescription'] . '"';
                            }; ?>
                               class="input-text ">

                    </div>

                    <div class="form-row">
                        <label><strong>Meta Keywords:</strong></label>
                        <input type="text" name="mkey" value="<?= $data['Meta_Keywords']; ?>" class="input-text ">
                    </div>

                        <div class="form-row">
                            <strong>Categories:</strong>
                        </div>

                        <div id="categories" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Select Categories</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div style="max-height: 400px; overflow-y: auto;">
                                            <ul class="categories">
                                                <?= $data['sd_cat']; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="build_categories" type="button" class="btn-primary" data-dismiss="modal">Ok</button>
                                        <button type="button" class="btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="panel panel-default form-row prod_sel_category_panel">
                            <div class="col-sm-12">

                                <div class="panel-body">
                                    <ul class="prod_sel_category">
                                        <?= $data['categories']; ?>
                                    </ul>
                                </div>
                                <div class="panel-footer">
                                    <a href="" id="edit_categories" class="button alt">Add</a>
                                </div>

                        </div>
                    </div>

                    <div class="form-row">
                        <label><strong>Width:</strong></label>
                        <input type="text" id="m_width" name="width" value="<?= $data['Width']; ?>" class="input-text ">
                    </div>

                    <div class="form-row">
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
                    </div>

                    <div class="form-row">
                        <label class="required_field" for="p_yard"><strong>Price:</strong></label>
                        <input type="text" id="p_yard" name="p_yard" value="<?= $data['Price_Yard']; ?>" class="input-text ">
                    </div>

                    <div class="form-row">
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
                    </div>

                    <div class="form-row">
                        <label><strong>Mfg. & Stock number:</strong></label>
                        <input type="text" name="st_nom" value="<?= $data['Stock_number']; ?>" class="input-text ">
                    </div>

                    <hr/>
                    <div class="form-row">
                        <label><strong>Dimensions:</strong></label>
                        <input type="text" name="dimens" value="<?= $data['Dimensions']; ?>" class="input-text ">
                    </div>

                    <div class="form-row">
                        <label for="current_inv"><strong>Current inventory:</strong></label>
                        <input type="text" id="current_inv" name="curret_in" value="<?= $data['Current_inventory']; ?>" class="input-text ">
                    </div>

                    <div class="form-row">
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
                    </div>

                        <div class="form-row">
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
                                <strong>NOTE:</strong> choosing any of Light, Medium, Heavy overrides the default weight
                                for the category.
                            </small>
                        </div>
                        <hr/>
                        <div class="form-row">
                            <label><strong>Manufacturer:</strong></label>
                            <select name="manufacturer">
                                <?= $data['Manufacturer']; ?>
                            </select>
                        </div>

                    <div class="form-row">
                        <label><strong>New Manufacturer:</strong></label>
                        <input type="text"
                               name="New_Manufacturer" <?= isset($data['New_Manufacturer']) ? 'value="' . $data['New_Manufacturer'] . '"' : '' ?>
                               class="input-text ">
                    </div>

                    <div class="form-row">
                        <label><strong>Colours: </strong></label>
                        <select multiple="" name="colors[]" style="height:85px;">
                            <?= $data['Colours']; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <label><strong>New Colour:</strong></label>
                        <input type="text"
                               name="new_color" <?= isset($data['New_Colour']) ? 'value="' . $data['New_Colour'] . '"' : '' ?>
                               class="input-text ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-row">
                        <label><strong>Short description:</strong></label>
                        <input type="text" value="<?= $data['Short_description']; ?>" name="short_desk" class="input-text ">
                    </div>

                    <div class="form-row">
                        <label><strong>Long description:</strong></label>
                        <textarea class="input-text " style="height: 117px" name="Long_description"><?= trim($data['Long_description']); ?></textarea>
                    </div>
                    <hr/>

                    <div class="form-row">
                        <label><strong>Main images:</strong></label>
                        <div class="text-center">
                            <div id="modify_images2" class="col-sm-12 col-md-12">
                                <div class="row">
                                <div class="row">
                                    <?= $modify_images; ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <hr style="margin-bottom: 0">
                    <small style="color:#999;"><b>NOTE</b>: Select a place, and then click "Upload file" to set the image there.</small>
                    <div class="col-md-12 text-center" style="margin-top: 15px">
                        <button id="upload" class="button alt" style="cursor: pointer;">Upload file</button>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="row">
                            <hr style="margin-bottom: 0">
                        </div>
                    </div>
                    <div class="form-row">
                        <label>
                            <strong>Pattern Types:</strong>
                            <select multiple="" name="patterns[]" style="height:85px;">
                                <?= $data['Pattern_Type']; ?>
                            </select>
                        </label>
                    </div>

                    <div class="form-row">
                        <label><strong>New Pattern Type:</strong>
                            <input type="text"
                                   name="new_pattern_type" <?= isset($data['New_Pattern']) ? 'value="' . $data['New_Pattern'] . '"' : '' ?>
                                   class="input-text ">
                        </label>
                    </div>

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
                </div>
            </div>
        </div>
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
<script src='<?= _A_::$app->router()->UrlTo('views/js/inputmask/jquery.inputmask.bundle.min.js'); ?>' type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/product/edit_form.js'); ?>' type="text/javascript"></script>
