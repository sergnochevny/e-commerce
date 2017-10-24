<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="box col-xs-12">
    <div class="row">
      <div class="col-xs-12">
        <div class="row">
          <div class="col-xs-12 col-sm-2 back_button_container">
            <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
              Back
            </a>
          </div>
          <div class="col-xs-12 col-sm-8 text-center">
            <div class="row">
              <h1 class="page-title"><?= $form_title ?></h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div data-role="form_content" class="row">
      <?= $form; ?>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/clearance/edit.min.js'); ?>' type="text/javascript"></script>
