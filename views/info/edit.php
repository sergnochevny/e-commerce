<script src="<?= _A_::$app->router()->UrlTo('tinymce/tinymce.min.js') ?>" type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('js/info/edit.min.js'); ?>' type="text/javascript"></script>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="box col-xs-12">
    <div class="col-xs-12 text-center">
      <div class="row">
        <h1 class="page-title"><?= $form_title ?></h1>
      </div>
    </div>

    <div data-role="form_content" class="row">
      <?= $form; ?>
    </div>
  </div>
</div>

