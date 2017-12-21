<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content">
  <div class="container inner-offset-top half-outer-offset-bottom">
    <div class="box">
      <div class="col-xs-12">
        <div class="row">
          <?php $back_url = App::$app->router()->UrlTo('shop'); ?>

          <div class="col-xs-12 col-sm-2 back_button_container">
            <div class="row">
              <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                To Shop
              </a>
            </div>
          </div>
          <div class="col-xs-12 col-sm-8 text-center">
            <h1 class="page-title half-inner-offset-bottom" style="margin-bottom: 15px">Contact Us</h1>
          </div>

          <div class="col-xs-12 col-sm-10 col-sm-offset-1  col-md-8 col-md-offset-2">
            <div class="row">
              <div class="col-xs-12">
                <h4 class="text-center">
                  Leave us a message
                  <br>
                  <small style="text-shadow: none">
                    Please feel free to contact us with your questions
                    or comments. Simply fill out the form below and one of our
                    representatives will contact you shortly.
                  </small>
                </h4>
              </div>
            </div>
            <div class="row">
              <div data-role="form_content" class="col-xs-12">
                <?= $form; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src='<?= App::$app->router()->UrlTo('js/static/static.min.js'); ?>' type="text/javascript"></script>
