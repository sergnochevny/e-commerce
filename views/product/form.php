<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>
<form id="edit_form" action="<?= $action ?>" method="post">
  <div data-fields_block class="col-xs-12">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label class="required_field"><b>Product name:</b></label>
              <input type="text" name="pname" value="<?= $data['pname']; ?>" class="input-text"
                     placeholder="e.g. Stunning Patterned Tapestry In Blue">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label class="required_field"><b>Product number:</b></label>
              <input type="text" name="pnumber" value="<?= $data['pnumber']; ?>" class="input-text"
                     placeholder="e.g. abc888999">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label><b>Mfg. & Stock number:</b></label>
              <input type="text" name="stock_number" value="<?= $data['stock_number']; ?>" class="input-text ">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label><b>Short description:</b></label>
              <input type="text" value="<?= $data['sdesc']; ?>" name="sdesc" class="input-text ">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label class="required_field"><b>Long description:</b></label>
              <textarea class="input-text " style="height: 117px"
                        name="ldesc"><?= trim($data['ldesc']); ?></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label><b>Meta Description:</b></label>
              <input type="text" name="metadescription"
                <?= !empty($data['metadescription']) ? 'value="' . $data['metadescription'] . '"' : ''; ?>
                     class="input-text" placeholder="e.g. Lovely patterned woven fabric, with stunning color combo">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label><b>Meta Keywords:</b></label>
              <input type="text" name="metakeywords" value="<?= $data['metakeywords']; ?>" class="input-text"
                     placeholder="Just a few words, separated by coma">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label><b>Manufacturer:</b></label>
              <select name="manufacturerId">
                <?= $data['manufacturers']; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row" style="margin-bottom: 10px">
          <div class="col-xs-12">
            <label><b>Types:</b></label>
            <div class="form-row">
              <?= $data['categories']; ?>
            </div>
          </div>
        </div>
        <div class="row" style="margin-bottom: 10px">
          <div class="col-xs-12">
            <label><b>Colors: </b></label>
            <div class="form-row">
              <?= $data['colors']; ?>
            </div>
          </div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-xs-12">
            <label><b>Patterns:</b></label>
            <div class="form-row">
              <?= $data['patterns']; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <div class="row">
                <div class="col-xs-12 col-sm-4">
                  <label class="inline pull-left" style="margin-left: 0">
                    <input type="checkbox" <?= (isset($data['piece']) && ($data['piece'] == "1")) ? 'checked' : '' ?>
                           value="1" name="piece" class="input-checkbox">
                    <b>Piece</b>
                  </label>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <label class="inline pull-left" style="margin-left: 0">
                    <input type="checkbox" <?= (isset($data['whole']) && ($data['whole'] == "1")) ? 'checked' : '' ?>
                           name="whole" value="1" class="input-checkbox">
                    <b>Whole</b>
                  </label>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <label class="inline pull-left" style="margin-left: 0">
                    <input type="checkbox" name="best"
                           value="1" <?= (isset($data['best']) && ($data['best'] == "1")) ? 'checked' : '' ?>
                           class="input-checkbox">
                    <b>Best Textiles</b>
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-4">
                  <label class="inline pull-left" style="margin-left: 0">
                    <input
                      type="checkbox" <?= (isset($data['specials']) && ($data['specials'] == "1")) ? 'checked' : '' ?>
                      name="specials" value="1" class="input-checkbox">
                    <b>Specials</b>
                  </label>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <label class='inline pull-left' style="margin-left: 0">
                    <input
                      type="checkbox" <?= (isset($data['pvisible']) && ($data['pvisible'] == "1")) ? 'checked' : '' ?>
                      name="pvisible" value="1" class="input-checkbox" style="vertical-align: 0">
                    <b style="vertical-align: 3px">Visible</b>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 visible-sm">
            <hr style="margin-top: 5px">
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-md-6">
        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label class="required_field"><b>Main image:</b></label>
              <div class="col-xs-12">
                <div id="images" class="row">
                  <?= $images; ?>
                </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <div class="col-xs-12">
              <small style="color:#999;"><b>NOTE</b>: Select a place, and then click "Upload file" to set the image
                there.
              </small>
            </div>
          </div>
        </div>

        <div class="col-xs-12 text-center" style="margin-top: 15px">
          <div class="row">
            <a data-img_upload id="upload" href="upload" class="button alt" style="cursor: pointer;">Upload file</a>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <hr style="margin: 25px 0">
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label class="required_field" for="p_yard"><b>Price:</b></label>
              <input data-inputmask="'alias': 'currency', 'prefix': '', 'rightAlign': 'false'" type="text" id="p_yard"
                     name="priceyard" value="<?= $data['priceyard']; ?>" class="input-text ">
            </div>
          </div>
        </div>
        <div class="form-row">
          <label class="inline" style="margin-left: 0; height: auto">
            <input
              type="checkbox" <?= (isset($data['hideprice']) && ($data['hideprice'] == "1")) ? 'checked' : '' ?>
              value="1" name="hideprice" class="input-checkbox">
            <b>Hide regular price</b>
          </label>
        </div>
        <div class="col-xs-12 form-row">
          <div class="row">
            <hr style="margin: 15px 0">
          </div>
        </div>
        <div class="form-row">
          <label for="current_inv"><b>Current inventory:</b></label>
          <input
            data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
            type="text" id="current_inv"
            name="inventory" value="<?= $data['inventory']; ?>"
            class="input-text ">
        </div>

        <div class="form-row">
          <label><b>Width:</b></label>
          <input
            data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
            type="text" id="m_width" name="width"
            value="<?= $data['width']; ?>" class="input-text ">
        </div>

        <div class="form-row">
          <label><b>Dimensions:</b></label>
          <input type="text" name="dimensions" value="<?= $data['dimensions']; ?>" class="input-text ">
        </div>

        <div class="form-row">
          <label><b>Weight:</b></label>
          <select name="weight_id">
            <option value="0" <?= ($data['weight_id'] == "0") ? 'selected' : ''; ?>>Use Category Weight</option>
            <option value="1" <?= ($data['weight_id'] == "1") ? 'selected' : ''; ?>>Light</option>
            <option value="2" <?= ($data['weight_id'] == "2") ? 'selected' : ''; ?>>Medium</option>
            <option value="3" <?= ($data['weight_id'] == "3") ? 'selected' : ''; ?>>Heavy</option>
          </select>
          <small class="note">
            <b>NOTE:</b> choosing any of Light, Medium, Heavy overrides the default weight
            for the category.
          </small>
        </div>


      </div>

      <div class="col-xs-12">
        <hr>
      </div>
    </div>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-12 panel panel-default" style="padding-bottom: 30px">
      <div data-related class="row products">
        <?= isset($related) ? $related : ''; ?>
      </div>
    </div>
  </div>

  <div data-submit_btn class="col-xs-12">
    <div class="text-center">
      <input type="button" id="submit" class="button" style="width: 150px;" value="Save"/>
    </div>
  </div>
  <div id="modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"
                                                                                         aria-hidden="true"></i>
          </button>
          <h4 id="modal-title" class="modal-title text-center"></h4>
        </div>
        <div class="modal-body clearfix" style="padding: 0;">
          <div id="modal_content">
          </div>
        </div>
        <div class="modal-footer">
          <button id="build_filter" href="filter" class="button" data-dismiss="modal">Ok</button>
          <button class="button" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</form>

<div data-related_block class="col-xs-12" style="display: none;">
  <div class="col-xs-12 panel panel-default" style="padding-bottom: 30px">
    <input data-related_get_list type="hidden"
           value="<?= App::$app->router()->UrlTo('related', ['pid' => $data['pid']]) ?>"/>
    <div id="content" data-edit_related class="row products"></div>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/product/form.min.js'), 6, true); ?>
