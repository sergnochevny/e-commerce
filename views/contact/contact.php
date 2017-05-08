<?php include('views/index/main_gallery.php'); ?>
<div id="content">
  <div class="container inner-offset-top half-outer-offset-bottom">
    <div class="row">
      <div class="col-xs-12">
        <div class="row">
          <div class="col-xs-12 text-center afterhead-row">
            <h1 class="page-title half-inner-offset-bottom" style="margin-bottom: 15px">Contact Us</h1>
          </div>
          <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center">
            <hr>
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

<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/static/static.min.js'); ?>' type="text/javascript"></script>
