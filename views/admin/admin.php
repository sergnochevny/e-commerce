<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <article class="page type-page status-publish entry">
            <h1 class="entry-title">Admin Account</h1>

            <div class="entry-content">
              <div class="woocommerce">
                <h2>Login</h2>

                <form method="POST" id="formx" action="<?= _A_::$app->router()->UrlTo('admin'); ?>"
                      class="login">
                  <input type="hidden" name="redirect"
                         value="<?= isset($redirect) ? $redirect : _A_::$app->router()->UrlTo('/'); ?>"/>
                  <p class="form-row form-row-wide">
                    <label for="username">Username <span class="required">*</span></label>
                    <input type="text" class="input-text" name="login" id="username" value=""/>
                  </p>

                  <p class="form-row form-row-wide">
                    <label for="password">Password <span class="required">*</span></label>
                    <input class="input-text" type="password" name="pass" id="password"/>
                  </p>

                  <p class="form-row">
                    <input type="hidden" id="_wpnonce" name="_wpnonce" value="c0312ae7bb"/>
                    <input type="hidden" name="_wp_http_referer" value="#"/>
                    <input type="submit" class="button" name="login" value="Login"/>
                    <label for="rememberme" class="inline">
                      <input name="rememberme" value="1" type="checkbox" id="rememberme"/>
                      Remember me
                    </label>
                  </p>

                  <p class="lost_password">
                    <a href="#">Lost your password?</a>
                  </p>
                  <div class="text-center">
                    <div class="results" style="color: red;"></div>
                  </div>
                </form>
              </div>
            </div>

          </article>
        </div>
      </div>
    </div>
  </div>
  <script src='<?= _A_::$app->router()->UrlTo('views/js/admin/admin.js'); ?>' type="text/javascript"></script>