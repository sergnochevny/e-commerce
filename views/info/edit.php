<script src="<?= _A_::$app->router()->UrlTo('tinymce/tinymce.min.js') ?>" type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/info/edit.js'); ?>' type="text/javascript"></script>
<div class="container">
  <div class="col-xs-12 text-center afterhead-row">
    <div class="row">
      <h3 class="page-title"><?= $form_title ?></h3>
    </div>
  </div>

  <div data-role="form_content" class="row">
    <?= $form; ?>
  </div>
</div>

