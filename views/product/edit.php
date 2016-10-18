<script type="text/javascript" src="<?= _A_::$app->router()->UrlTo('upload/js/ajaxupload.3.5.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('upload/styles.css'); ?>">
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="row afterhead-row">
        <div class="col-xs-12 col-sm-2 back_button_container">
          <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        </div>
        <div class="col-xs-12 col-sm-8">
          <div class="row">
            <h1 class="page-title"><?= $form_title ?></h1>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div id="form_content" class="row">
      <?= $form; ?>
  </div>
  <div id="confirm_dialog" class="overlay"></div>
  <div class="popup">
    <div class="fcheck"></div>
    <a class="close" title="close">&times;</a>

    <div class="b_cap_cod_main">
      <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
      <br/>
      <div class="text-center" style="width: 100%">
        <a id="confirm_action"><input type="button" value="Yes confirm" class="button"/></a>
        <a id="confirm_no"><input type="button" value="No" class="button"/></a></div>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/product/images.js'); ?>' type="text/javascript"></script>