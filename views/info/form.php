<?php

use app\core\App;

?>

<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>
<form id="edit_form" action="<?= $action ?>" method="post">
  <div data-fields_block class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 info_form">
    <div class="row">
      <div class="col-sm-12">
        <div class="form-row">
          <label class="required_field"><b>Title:</b></label>
          <input type="text" name="title" value="<?= $data['title']; ?>" class="input-text"
                 placeholder="Title"/>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-row">
          <label class="required_field"><b>Content:</b></label>
          <textarea id="editable_content" name="message" class="input-text" placeholder="Content">
            <?= $data['message']; ?>
          </textarea>
        </div>
      </div>
      <?php if($scenario == 'cart'): ?>
        <div class="col-sm-12">
          <div class="form-row">
            <label><b>Timeout (min):</b></label>
            <input type="number" value="<?= $data['f2']; ?>" name="f2" class="input-text "/>
          </div>
        </div>
      <?php endif; ?>
      <div class="col-sm-12">
        <div class="form-row">
          <label><b>Publish:</b></label>
          <input type="checkbox" name="visible" value="1" <?= ($data['visible']) ? 'checked' : ''; ?>/>
        </div>
      </div>
    </div>
    <div data-submit_btn class="col-xs-12">
      <div class="text-center">
        <input type="button" id="submit" class="button" style="width: 150px;" value="Save"/>
      </div>
    </div>
  </div>
</form>
<script src='<?= App::$app->router()->UrlTo('js/info/form.min.js'); ?>' type="text/javascript"></script>
