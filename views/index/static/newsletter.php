<?php include('views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 box">
    <div class="col-xs-12 text-center">
      <div class="row">
        <h1 class="page-title">I Luv Fabrix Newsletter</h1>
        <h2 class="page-title">
          <small>DESIGNER UPHOLSTERY/ DRAPERY FABRIC SUPERSALE</small>
        </h2>
      </div>
    </div>

    <?php if(!Controller_User::is_logged()): ?>
      <div class="col-xs-12">
        <div class="row">
          <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <h4>Register for our newsletter to benefit from:</h4>
            <ul>
              <li>exclusive offers only given to members</li>
              <li> first to know of any limited time fabric discounts</li>
              <li>new features & website tools</li>
            </ul>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <div class="row">
                  <div class="col-xs-12" data-role="form_content">
                    <div data-load="<?= _A_::$app->router()->UrlTo('user/registration', ['method' => 'short']) ?>">
                      <script type='text/javascript'
                              src='<?= _A_::$app->router()->UrlTo('views/js/load.min.js'); ?>'></script>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/static/static.min.js'); ?>' type="text/javascript"></script>

