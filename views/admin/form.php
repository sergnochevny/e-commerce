<?php include_once 'views/messages/alert-boxes.php'; ?>
<form id="edit_form" action="<?= $action ?>" method="post">
  <div class="col-md-push-2 col-md-8">
    <div class="form-row">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-xs-12">
            <label class="required_field"><strong>Login:</strong></label>
            <input type="text" name="login" value="<?= $data['login'] ?>" class="input-text " autofocus/>
          </div>
          <div class="col-sm-6">
            <label><strong>Password:</strong></label>
            <input type="password" name="create_password" class="input-text ">
          </div>
          <div class="col-sm-6">
            <label><strong>Confirm Password:</strong></label>
            <input type="password" name="confirm_password" class="input-text ">
          </div>
        </div>
      </div>
      <div class="text-center">
        <input type="submit" value="SAVE" class="button"/>
      </div>
    </div>
  </div>
</form>
<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/formsimple/form.min.js'); ?>' type="text/javascript"></script>