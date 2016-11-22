<script src='<?= _A_::$app->router()->UrlTo('views/js/inputmask/jquery.inputmask.bundle.min.js'); ?>'
        type="text/javascript"></script>

<div class="container">
  <div class="col-xs-12 text-center afterhead-row">
    <div class="row">
      <h3 class="page-title"><?= $form_title ?></h3>
    </div>
  </div>

  <div id="form_content" class="row">
    <?= $form; ?>
  </div>
</div>
