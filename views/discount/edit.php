<body
  class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.css'); ?>">
<script src="<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>"></script>
<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content main-content-shop">
    <div class="container">
      <div id="content" class="main-content-inner" role="main">
        <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        <div>
          <h1 class="page-title"><?= $form_title ?></h1>
          <div class="col-sm-12 text-center" style="margin-bottom: 25px">
            <small style="color: black; font-size: 12px;">
              Use this form to add/update discounts to the system. <br/>
            </small>
            <div class="row">
              <hr>
            </div>
            <small style="color: black; font-size: 12px;">
              Clicking on the section title will open a help file explaining that section.
            </small>
          </div>
          <div id="form_content">
            <?= $form; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('views/discount/modal_rules.php'); ?>