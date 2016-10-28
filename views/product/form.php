<?php include_once 'views/messages/alert-boxes.php'; ?>
<form id="edit_form" action="<?= $action ?>" method="post">
  <div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-row">
            <label class="required_field"><b>Product name:</b></label>
            <input type="text" name="pname" value="<?= $data['pname']; ?>" class="input-text"
                   placeholder="e.g. Stunning Patterned Tapestry In Blue">
          </div>

          <div class="form-row">
            <label class="required_field"><b>Product number:</b></label>
            <input type="text" name="pnumber" value="<?= $data['pnumber']; ?>" class="input-text"
                   placeholder="e.g. abc888999">
          </div>

          <div class="form-row">
            <label><b>Meta Description:</b></label>
            <input type="text" name="metadescription"
              <?= !empty($data['metadescription']) ? 'value="' . $data['metadescription'] . '"' : ''; ?>
                   class="input-text" placeholder="e.g. Lovely patterned woven fabric, with stunning color combo">
          </div>

          <div class="form-row">
            <label><b>Meta Keywords:</b></label>
            <input type="text" name="metakeywords" value="<?= $data['metakeywords']; ?>" class="input-text"
                   placeholder="Just a few words, separated by coma">
          </div>

          <div class="form-row">
            <label><b>Categories:</b></label>
            <div>
              <?= $data['categories']; ?>
            </div>
          </div>
          <div class="form-row">
            <label><b>Colours: </b></label>
            <div>
              <?= $data['colours']; ?>
            </div>
          </div>
          <div class="form-row">
            <label>
              <b>Pattern Types:</b>
            </label>
            <div>
              <?= $data['patterns']; ?>
            </div>
          </div>
          <div class="form-row">
            <label><b>Width:</b></label>
            <input type="text" id="m_width" name="width" value="<?= $data['width']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label>
              <b>Piece:</b>
              <input type="checkbox" <?= (isset($data['piece']) && ($data['piece'] == "1")) ? 'checked' : '' ?>
                     value="1" name="piece" class="input-checkbox">
            </label>
          </div>

          <div class="form-row">
            <label class="required_field" for="p_yard"><b>Price:</b></label>
            <input type="text" id="p_yard" name="priceyard" value="<?= $data['priceyard']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label>
              <b>Hide regular price:</b>
              <input type="checkbox" <?= (isset($data['hideprice']) && ($data['hideprice'] == "1")) ? 'checked' : '' ?>
                     value="1" name="hideprice" class="input-checkbox">
            </label>
          </div>

          <div class="form-row">
            <label><b>Mfg. & Stock number:</b></label>
            <input type="text" name="stock_number" value="<?= $data['stock_number']; ?>" class="input-text ">
          </div>

          <hr/>
          <div class="form-row">
            <label><b>Dimensions:</b></label>
            <input type="text" name="dimensions" value="<?= $data['dimensions']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label for="current_inv"><b>Current inventory:</b></label>
            <input type="text" id="current_inv" name="inventory" value="<?= $data['inventory']; ?>"
                   class="input-text ">
          </div>

          <div class="form-row">
            <label><b>Weight:</b></label>
            <select name="weight_id">
              <option value="0" <?= ($data['weight_id'] == "0") ? 'selected' : ''; ?>>Use Category Weight</option>
              <option value="1" <?= ($data['weight_id'] == "1") ? 'selected' : ''; ?>>Light</option>
              <option value="2" <?= ($data['weight_id'] == "2") ? 'selected' : ''; ?>>Medium</option>
              <option value="3" <?= ($data['weight_id'] == "3") ? 'selected' : ''; ?>>Heavy</option>
            </select>
            <small style="color:#999;">
              <b>NOTE:</b> choosing any of Light, Medium, Heavy overrides the default weight
              for the category.
            </small>
          </div>
          <hr/>
          <div class="form-row">
            <label class="inline" style="margin-left: 0">
              <b>Whole:</b>
              <input type="checkbox" <?= (isset($data['whole']) && ($data['whole'] == "1")) ? 'checked' : '' ?>
                     name="whole" value="1" class="input-checkbox">
            </label>
          </div>
          <hr/>
          <div class="form-row">
            <label><b>Manufacturer:</b></label>
            <select name="manufacturerId">
              <?= $data['manufacturers']; ?>
            </select>
          </div>

        </div>
        <div class="col-md-6">
          <div class="form-row">
            <label><b>Main images:</b></label>
            <div class="text-center">
              <div id="images" class="col-sm-12 col-md-12">
                <div class="row">
                  <?= $images; ?>
                </div>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="form-row">
            <label><b>Short description:</b></label>
            <input type="text" value="<?= $data['sdesc']; ?>" name="sdesc" class="input-text ">
          </div>

          <div class="form-row">
            <label><b>Long description:</b></label>
            <textarea class="input-text " style="height: 117px"
                      name="ldesc"><?= trim($data['ldesc']); ?></textarea>
          </div>
          <hr/>

          <small style="color:#999;"><b>NOTE</b>: Select a place, and then click "Upload file" to set the image there.
          </small>
          <div class="col-md-12 text-center" style="margin-top: 15px">
            <a id="upload" class="button alt" style="cursor: pointer;">Upload file</a>
          </div>

          <p>
            <label>
              <b style="vertical-align: 3px">Best Textile:</b>
              <input type="checkbox" name="best"
                     value="1" <?= (isset($data['best']) && ($data['best'] == "1")) ? 'checked' : '' ?>
                     class="input-checkbox">
            </label><br>
            <label>
              <b style="vertical-align: 3px">Specials:</b>
              <input type="checkbox" <?= (isset($data['specials']) && ($data['specials'] == "1")) ? 'checked' : '' ?>
                     name="specials" value="1" class="input-checkbox">
            </label><br>
            <label>
              <b style="vertical-align: 3px">Visible:</b>
              <input type="checkbox" <?= (isset($data['pvisible']) && ($data['pvisible'] == "1")) ? 'checked' : '' ?>
                     name="pvisible" value="1" class="input-checkbox">
            </label>
          </p>
        </div>
      </div>
    </div><!--col-2-->

    <div class="col-xs-12">
      <hr>
    </div>
    <div class="col-xs-12">
      <div class="text-center">
        <a id="submit" class="button" style="width: 150px;">Save</a>
      </div>
    </div>

    <div id="modal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 id="modal-title" class="modal-title text-center"></h4>
          </div>
          <div class="modal-body" style="padding: 0;">
            <div id="modal_content">
            </div>
          </div>
          <div class="modal-footer">
            <a id="build_filter" href="filter" class="btn btn-primary" data-dismiss="modal">Ok</a>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/inputmask/jquery.inputmask.bundle.min.js'); ?>'
        type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/product/form.js'); ?>' type="text/javascript"></script>
