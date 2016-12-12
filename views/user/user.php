<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 text-center afterhead-row">
      <h2 class="page-title">Login</h2>
    </div>

    <div class="col-xs-12 col-sm-6">
      <div class="col-xs-12 panel panel-default panel-default-vertical-sizing authorize-panel">
        <div class="col-xs-12">
          <div class="row">
            <form method="post" id="authorization" action="<?= _A_::$app->router()->UrlTo('user'); ?>"
                  class="login">
              <input type="hidden" name="redirect"
                     value="<?= isset($redirect) ? $redirect : _A_::$app->router()->UrlTo('/'); ?>"/>

              <div class="form-row">
                <label for="username" class="required_field">Email Address/Username</label>
                <input type="text" class="input-text" name="login" id="username" value="" autofocus/>
              </div>

              <div class="form-row form-row-wide">
                <label for="password" class="required_field">Password</label>
                <input class="input-text" type="password" name="pass" id="password"/>
              </div>

              <div class="row">
                <div class="col-xs-6">
                  <input data-link id="login" type="submit" class="button" value="Login"/>
                </div>
                <div class="col-xs-6 text-right">
                  <label for="rememberme" class="inline">
                    Remember me
                    <input class="rememberme" name="rememberme" value="1" type="checkbox" id="rememberme"/>
                  </label>
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
      </div>

      <div class="col-xs-12">
        <div class="row">
          <a id="lost_password" href="<?= $lostpassword_url ?>">Lost your password?</a>
        </div>
      </div>

    </div>

    <div class="col-xs-12 col-sm-6">
      <div class="col-xs-12 panel panel-default panel-default-vertical-sizing register-panel">
        <div class="col-xs-12">
          <div class="row">
            <p>
              Please click "Create Account" and become a registered customer to use the "Fabric Favorites",
              "Recommendations" and "My Account" feature.
            </p>
            <p>
              If you have not previously registered
              with I luv fabrix, please click
              CREATE ACCOUNT.
              (Credit Card information NOT REQUIRED)
            </p>
          </div>
        </div>
        <div class="col-xs-12 register-button">
          <div class="row text-center">
            <a id="register_user" class="btn button" href="<?= $registration_url ?>">Create Account</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/authorization/authorization.min.js'); ?>'
        type="text/javascript"></script>