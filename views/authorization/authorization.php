<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12">

      <div class="col-xs-12 col-sm-12 text-center afterhead-row">
        <h2 class="page-title">Login</h2>
      </div>

      <div class="col-xs-12 col-sm-8 col-sm-push-2 panel panel-default panel-default-vertical-sizing">
        <div class="col-xs-12">
          <form method="post" id="authorization" action="<?= _A_::$app->router()->UrlTo('authorization'); ?>"
                class="login">
            <input type="hidden" name="redirect"
                   value="<?= isset($redirect) ? $redirect : _A_::$app->router()->UrlTo('/'); ?>"/>

            <div class="form-row">
              <label for="username" class="required-field">Email Address/Username</label>
              <input type="text" class="input-text" name="login" id="username" value="" autofocus/>
            </div>

            <div class="form-row form-row-wide">
              <label for="password" class="required-field">Password</label>
              <input class="input-text" type="password" name="pass" id="password"/>
            </div>

            <div class="form-row">
              <div class="col-xs-6">
                <div class="row">
                  <input data-link id="blogin" type="submit" class="button" value="Login"/>
                </div>
              </div>
              <div class="col-xs-6 text-right">
                <div class="row">
                  <label for="rememberme" class="inline">
                    Remember me
                    <input name="rememberme" value="1" type="checkbox" id="rememberme"/>
                  </label>
                </div>
              </div>
            </div>

            <div class="col-xs-12">
              <div class="row text-center">
                <div class="results" style="color: red;"></div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <a id="lost_password" href="<?= $lostpassword_url ?>">Lost your password?</a>
        <a id="register_user" href="<?= $registration_url ?>" style="float: right;">Registration</a>
      </div>

    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/authorization/authorization.js'); ?>'
        type="text/javascript"></script>