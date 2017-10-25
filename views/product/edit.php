<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('css/upload.min.css'); ?>">
<script src='<?= _A_::$app->router()->UrlTo('js/product/images.min.js'); ?>' type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('js/product/related.min.js'); ?>' type="text/javascript"></script>

<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 box">
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
    <div data-role="form_content" class="row">
      <?= $form; ?>
    </div>
  </div>

  <div id="confirm_dialog" class="overlay"></div>
  <div class="popup">
    <div class="fcheck"></div>
    <a class="close" href="javascript:void(0)" title="close"><i class="fa fa-times" aria-hidden="true"></i></a>

    <div class="b_cap_cod_main">
      <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
      <br/>
      <div class="text-center" style="width: 100%">
        <input id="confirm_action" type="button" value="Yes confirm" class="button"/>
        <input id="confirm_no" type="button" value="No" class="button"/>
      </div>
    </div>
  </div>
