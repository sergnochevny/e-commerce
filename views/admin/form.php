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

  <h1 class="page-title"><?= $form_title ?></h1>

  <div class="col-1">
    <p class="form-row">
      <label class="required_field"><strong>Login:</strong></label>
      <input type="text" name="login" value="<?= $data['login'] ?>"
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
    <div class="text-center">
      <input type="submit" value="SAVE" class="button"/>
    </div>
  </div>
</form>
<input type="hidden" id="base_url" value="<?= _A_::$app->router()->UrlTo('/') ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/form.js'); ?>' type="text/javascript"></script>