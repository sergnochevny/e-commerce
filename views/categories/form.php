<form id="edit_form" action="<?= $action ?>" method="post">
  <hr>
  <p class="text-center">
    <small style="color: black; font-size: 13px;">
      Use this form to add/update the title and details of the offer.<br/>
    </small>
  </p>
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-10 col-xs-12">
        <div class="form-row">
          <label class="required_field"><strong>Category:</strong></label>
          <input type="text" name="category" value="<?= $data['cname'] ?>" class="input-text ">
          <small style="color: #999">NOTE: the title cannot be more than 28 characters.</small>
        </div>
      </div>
      <div class="col-md-2 col-xs-12">
        <div class="form-row">
          <label class="required_field"><strong>Display order:</strong></label>
          <input name="display_order" type="number" value="<?= $data['display_order'] ?>" class="input-text ">
        </div>
      </div>
      <?php if(isset($warning)) { ?>
        <div class="col-xs-12 alert-success danger" style="display: none;"><?php
            foreach($warning as $msg) {
              echo $msg . "\r\n";
            }
          ?></div>
      <?php } ?>
      <?php if(isset($error)) { ?>
        <div class="col-xs-12 alert-danger danger" style="display: none;"><?php
            foreach($error as $msg) {
              echo $msg . "\r\n";
            }
          ?></div>
      <?php } ?>
    </div>
  </div>
  <br/>
  <br/>
  <div class="text-center"><input type="submit" value="<?= isset($category_id)?'Update':'Save'?>" class="button"/>
  </div>

</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/categories/form.js'); ?>' type="text/javascript"></script>