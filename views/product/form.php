<?php
  if(isset($warning)) {
    ?>
    <div class="col-xs-12 alert-success danger" style="display: none;">
      <?php
        foreach($warning as $msg) {
          echo '<span>' . $msg . '</span>';
        }
      ?>
    </div>
    <?php
  }
?>
<?php
  if(isset($error)) {
    ?>
    <div class="col-xs-12 alert-danger danger" style="display: none;">
      <?php
        foreach($error as $msg) {
          echo $msg;
        }
      ?>
    </div>
    <?php
  }
?>
<form id="edit_form" action="<?= $action ?>" method="post">
  <div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-row">
            <label class="required_field"><strong>Product name:</strong></label>
            <input type="text" name="pname" value="<?= $data['pname']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label class="required_field"><strong>Product number:</strong></label>
            <input type="text" name="pnumber" value="<?= $data['pnumber']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label><strong>Meta Description:</strong></label>
            <input type="text" name="metadescription"
              <?= !empty($data['metadescription']) ? 'value="' . $data['metadescription'] . '"' : ''; ?>
                   class="input-text ">
          </div>

          <div class="form-row">
            <label><strong>Meta Keywords:</strong></label>
            <input type="text" name="metakeywords" value="<?= $data['metakeywords']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label><strong>Categories:</strong></label>
            <div>
              <?= $data['categories']; ?>
            </div>
          </div>

          <div class="form-row">
            <label><strong>Width:</strong></label>
            <input type="text" id="m_width" name="width" value="<?= $data['width']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label>
              <strong>Piece:</strong>
              <input type="checkbox" <?= (isset($data['piece']) && ($data['piece'] == "1")) ? 'checked' : '' ?>
                     value="1" name="piece" class="input-checkbox">
            </label>
          </div>

          <div class="form-row">
            <label class="required_field" for="p_yard"><strong>Price:</strong></label>
            <input type="text" id="p_yard" name="priceyard" value="<?= $data['priceyard']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label>
              <strong>Hide regular price:</strong>
              <input type="checkbox" <?= (isset($data['hideprice']) && ($data['hideprice'] == "1")) ? 'checked' : '' ?>
                     value="1" name="hideprice" class="input-checkbox">
            </label>
          </div>

          <div class="form-row">
            <label><strong>Mfg. & Stock number:</strong></label>
            <input type="text" name="stock_number" value="<?= $data['stock_number']; ?>" class="input-text ">
          </div>

          <hr/>
          <div class="form-row">
            <label><strong>Dimensions:</strong></label>
            <input type="text" name="dimensions" value="<?= $data['dimensions']; ?>" class="input-text ">
          </div>

          <div class="form-row">
            <label for="current_inv"><strong>Current inventory:</strong></label>
            <input type="text" id="current_inv" name="inventory" value="<?= $data['inventory']; ?>"
                   class="input-text ">
          </div>

          <div class="form-row">
            <label>
              <strong>Whole:</strong>
              <input type="checkbox" <?= (isset($data['whole']) && ($data['whole'] == "1")) ? 'checked' : '' ?>
                     name="whole" value="1" class="input-checkbox">
            </label>
          </div>

          <div class="form-row">
            <label><strong>Weight:</strong></label>
            <select name="weight_id">
              <option value="0" <?= ($data['weight_id'] == "0") ? 'selected' : ''; ?>>Use Category Weight</option>
              <option value="1" <?= ($data['weight_id'] == "1") ? 'selected' : ''; ?>>Light</option>
              <option value="2" <?= ($data['weight_id'] == "2") ? 'selected' : ''; ?>>Medium</option>
              <option value="3" <?= ($data['weight_id'] == "3") ? 'selected' : ''; ?>>Heavy</option>
            </select>
            <small style="color:#999;">
              <strong>NOTE:</strong> choosing any of Light, Medium, Heavy overrides the default weight
              for the category.
            </small>
          </div>
          <hr/>
          <div class="form-row">
            <label><strong>Manufacturer:</strong></label>
            <select name="manufacturers">
              <?= $data['manufacturers']; ?>
            </select>
          </div>

          <div class="form-row">
            <label><strong>Colours: </strong></label>
            <div>
              <?= $data['colours']; ?>
            </div>
          </div>

        </div>
        <div class="col-md-6">
          <div class="form-row">
            <label><strong>Short description:</strong></label>
            <input type="text" value="<?= $data['sdesc']; ?>" name="sdesc" class="input-text ">
          </div>

          <div class="form-row">
            <label><strong>Long description:</strong></label>
            <textarea class="input-text " style="height: 117px"
                      name="ldesc"><?= trim($data['ldesc']); ?></textarea>
          </div>
          <hr/>

          <div class="form-row">
            <label><strong>Main images:</strong></label>
            <div class="text-center">
              <div id="images" class="col-sm-12 col-md-12">
                <div class="row">
                  <div class="row">
                    <?= $images; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <hr style="margin-bottom: 0">
          <small style="color:#999;"><b>NOTE</b>: Select a place, and then click "Upload file" to set the image there.
          </small>
          <div class="col-md-12 text-center" style="margin-top: 15px">
            <a id="upload" class="button alt" style="cursor: pointer;">Upload file</a>
          </div>
          <div class="col-md-12 text-center">
            <div class="row">
              <hr style="margin-bottom: 0">
            </div>
          </div>
          <div class="form-row">
            <label>
              <strong>Pattern Types:</strong>
            </label>
            <div>
              <?= $data['patterns']; ?>
            </div>
          </div>

          <hr/>
          <p>
            <label>
              <strong style="vertical-align: 3px">Best Textile:</strong>
              <input type="checkbox" name="best"
                     value="1" <?= (isset($data['best']) && ($data['best'] == "1")) ? 'checked' : '' ?>
                     class="input-checkbox">
            </label><br>
            <label>
              <strong style="vertical-align: 3px">Specials:</strong>
              <input type="checkbox" <?= (isset($data['specials']) && ($data['specials'] == "1")) ? 'checked' : '' ?>
                     name="specials" value="1" class="input-checkbox">
            </label><br>
            <label>
              <strong style="vertical-align: 3px">Visible:</strong>
              <input type="checkbox" <?= (isset($data['pvisible']) && ($data['pvisible'] == "1")) ? 'checked' : '' ?>
                     name="pvisible" value="1" class="input-checkbox">
            </label>
          </p>
        </div>
      </div>
    </div><!--col-2-->

    <div class="col-xs-12">
      <div class="text-center">
        <a id="submit" type="button" class="button" style="width: 150px;">Save</a>
      </div>
    </div>

    <div id="modal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 id="modal-title" class="modal-title"></h4>
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
