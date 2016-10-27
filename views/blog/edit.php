<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('upload/styles.css'); ?>">
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="row afterhead-row">
        <div class="col-sm-2 back_button_container">
          <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        </div>
        <div class="col-sm-10 text-center">
          <div class="row">
            <h3 class="page-title"><?= $form_title ?></h3>
          </div>
        </div>
        <div class="col-sm-2 text-center"></div>
        </div>
      </div>
    </div>
  </div>

  <div id="form_content" class="row">
      <?= $form; ?>
  </div>
</div>
<script defer src="<?= _A_::$app->router()->UrlTo('tinymce/tinymce.min.js') ?>" type="text/javascript"></script>
<script defer src='<?= _A_::$app->router()->UrlTo('views/js/blog/edit.js'); ?>' type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/image.js'); ?>' type="text/javascript"></script>