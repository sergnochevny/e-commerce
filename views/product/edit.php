<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="row afterhead-row">
        <div class="col-xs-12 back_button_container">
          <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        </div>
        <div class="col-xs-12 text-center">
          <div class="row">
            <h3 class="page-title"><?= $form_title ?></h3>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
      <?= $form; ?>
  </div>
</div>
<script type="text/javascript" src="<?= _A_::$app->router()->UrlTo('upload/js/ajaxupload.3.5.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('upload/styles.css'); ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/product/images.js'); ?>' type="text/javascript"></script>