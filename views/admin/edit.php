<div class="container">
  <div id="content" class="main-content-inner" role="main">
    <div class="row">
      <div class="col-xs-12">
        <div class="row afterhead-row">
          <div class="col-sm-2 back_button_container">
            <a href="<?= $back_url; ?>" class="button back_button">Back</a>
          </div>
          <div class="col-sm-8 text-center">
            <div class="row">
              <h3 class="page-title"><?= $form_title ?></h3>
            </div>
          </div>
          <div class="col-sm-2"></div>
        </div>
      </div>
    </div>

    <div id="form_content" class="row">
      <?= $form; ?>
    </div>
  </div>
</div>
