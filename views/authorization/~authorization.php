<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="row">
    <div class="col-xs-12 col-sm-12 text-center">
      <h2 class="page-title">Login</h2>
    </div>

    <div class="col-xs-12 col-sm-12 text-center">
      <span class="page-title">To enable all features of iluvfabrix.com please register or sign-in below</span>
    </div>

    <div class="col-xs-12 col-md-6">
      <div class="col-xs-12 panel panel-default panel-default-vertical-sizing authorize-panel">
        <div class="col-xs-12">
          <div class="row">
            <form method="post" id="authorization" action="<?= _A_::$app->router()->UrlTo('authorization'); ?>"
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
            <a data-waitloader id="lost_password" href="<?= $lostpassword_url ?>">Lost your password?</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-6 panel-default-vertical-sizing">
      <div class="col-xs-12 panel panel-default">
        <div class="row">
          <div class="col-xs-12 text-center">
            <h4>Register with iluvfabrix:</h4>
          </div>
          <div class="col-xs-12" data-role="form_content">
            <div data-load="<?= _A_::$app->router()->UrlTo('user/registration', ['method' => 'short']) ?>">
              <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('js/load.min.js'); ?>'></script>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('js/authorization/authorization.min.js'); ?>'
        type="text/javascript"></script>
