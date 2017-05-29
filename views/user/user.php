<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="row">
    <div class="col-xs-12 col-sm-12 text-center">
      <h2 class="page-title">Login</h2>
    </div>

    <div class="col-xs-12 col-sm-12 text-center">
      <label>To enable all features of iluvfabrix.com please register or sign-in below</label>
    </div>

    <div class="col-xs-12 col-md-8 col-md-offset-2">
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

        <div class="col-xs-12">
          <div class="row inner-offset-vertical-top">
            <div class="col-xs-6">
              <div class="row">
                <a data-waitloader id="lost_password" href="<?= $lostpassword_url ?>">Lost your password?</a>
              </div>
            </div>
            <div class="col-xs-6 text-right">
              <div class="row">
                <a data-waitloader href="<?= $registration_url ?>">Registration</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12">
      <div class="row inner-offset-vertical text-center">
        <a data-waitloader class="button" href="<?= _A_::$app->router()->UrlTo('shop'); ?>">
          No, I would just like to Shop instead
        </a>
      </div>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/authorization/authorization.min.js'); ?>'
        type="text/javascript"></script>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/load.min.js'); ?>'></script>
