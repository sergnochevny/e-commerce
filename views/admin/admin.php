<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="row">
    <div class="col-xs-12 col-sm-12">

      <div class="col-xs-12 text-center">
        <h2 class="page-title">Login</h2>
      </div>
      
      <div class="col-xs-12 col-sm-8 col-sm-push-2 panel panel-default panel-default-vertical-sizing">
        <div class="col-xs-12">

          <form method="POST" id="authorization" action="<?= _A_::$app->router()->UrlTo('admin'); ?>"
                class="login">
              <input type="hidden" name="redirect"
                     value="<?= isset($redirect) ? $redirect : _A_::$app->router()->UrlTo('/'); ?>"/>
              <div class="form-row">
                <label for="username" class="required_field">Username</label>
                <input type="text" class="input-text" name="login" id="username" value="" autofocus/>
              </div>

              <div class="form-row">
                <label for="password" class="required_field">Password</label>
                <input class="input-text" type="password" name="pass" id="password"/>
              </div>

              <div class="form-row">
                <div class="col-xs-6">
                  <div class="row">
                    <input data-link id="login" type="submit" class="button" value="Login"/>
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
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('js/authorization/authorization.min.js'); ?>'
        type="text/javascript"></script>