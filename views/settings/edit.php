<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="row afterhead-row">
        <div class="col-sm-12 text-center">
          <div class="row">
            <h3 class="page-title"><?= $form_title ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div data-role="form_content" class="row">
    <?= $form; ?>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/settings/edit.js'); ?>' type="text/javascript"></script>
