<?php include_once 'views/messages/alert-boxes.php'; ?>
<form id="edit_form" action="<?= $action ?>" method="post">
  <div data-fields_block class="col-xs-12">
    <div class="row">
      <div class="col-sm-12">
        <div class="form-row">
          <label class="required_field"><b>Title:</b></label>
          <input type="text" name="pname" value="<?= $data['title']; ?>" class="input-text"
                 placeholder="Title">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-row">
          <label class="required_field"><b>Content:</b></label>
          <input type="textarea" name="pnumber" value="<?= $data['message']; ?>" class="input-text"
                 placeholder="e.g. abc888999">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-row">
          <label><b>Timeout (min):</b></label>
          <input type="number" value="<?= $data['f2']; ?>" name="f2" class="input-text ">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-row">
          <label><b>Publish:</b></label>
          <input type="checkbox" name="visible" value="<?= $data['visible']; ?>" class="input-text ">
        </div>
      </div>
    </div>
  </div>

  <div data-submit_btn class="col-xs-12">
    <div class="text-center">
      <a id="submit" href="save" class="button" style="width: 150px;">Save</a>
    </div>
  </div>

</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/info/form.js'); ?>' type="text/javascript"></script>
