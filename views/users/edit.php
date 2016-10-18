<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="row afterhead-row">
        <div class="col-xs-12 back_button_container">
          <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        </div>
        <div class="col-xs-12 text-center">
          <div class="row">
            <h1 class="page-title"><?= $form_title ?></h1>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div id="form_content" class="col-sm-8 col-md-offset-2">
      <?= $form; ?>
    </div>
  </div>
</div>