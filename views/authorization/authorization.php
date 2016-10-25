<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-push-2 col-xs-12">
      <div class="col-md-12 col-xs-12 text-center">
        <h1 class="entry-title">Login</h1>
      </div>
      <div class="col-md-12 col-xs-12 entry-content">
        <div class="woocommerce">
          <form method="post" id="authorization" action="<?= _A_::$app->router()->UrlTo('authorization'); ?>"
                class="login">
            <input type="hidden" name="redirect"
                   value="<?= isset($redirect) ? $redirect : _A_::$app->router()->UrlTo('/'); ?>"/>

            <div class="form-row">
              <label for="username">Email Address/Username <span class="required">*</span></label>
              <input type="text" class="input-text" name="login" id="username" value=""/>
            </div>

            <div class="form-row form-row-wide">
              <label for="password">Password <span class="required">*</span></label>
              <input class="input-text" type="password" name="pass" id="password"/>
            </div>

            <div class="form-row">
              <input type="hidden" id="_wpnonce" name="_wpnonce" value="c0312ae7bb"/>
              <input type="hidden" name="_wp_http_referer" value="#"/>
              <input id="blogin" type="button" class="button" name="login"
                     data-action="<?= _A_::$app->router()->UrlTo('authorization'); ?>" value="Login"/>
              <label for="rememberme" class="inline">
                <input name="rememberme" value="1" type="checkbox" id="rememberme"/>
                Remember me
              </label>
            </div>

            <div class="lost_password">
              <a id="lost_password" href="<?= $lostpassword_url ?>">Lost your password?</a>
              <a id="register_user" href="<?= $registration_url ?>" style="float: right;">Registration</a>
            </div>

            <div class="text-center">
              <div class="results" style="color: red;"></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/authorization/authorization.js'); ?>'
        type="text/javascript"></script>