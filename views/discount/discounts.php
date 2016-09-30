<body
  class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content main-content-shop">
    <div class="container">
      <div id="content" class="main-content-inner" role="main">
        <?= $list; ?>
      </div>
    </div>

    <div id="confirm_dialog" class="overlay"></div>
    <div class="popup">
      <div class="fcheck"></div>
      <a class="close" title="close">&times;</a>
      <div class="b_cap_cod_main">
        <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
        <br/>
        <div class="text-center" style="width: 100%">
          <input id="confirm_action" type="button" value="Yes confirm" class="button"/>
          <input id="confirm_no" type="button" value="No" class="button"/>
        </div>
      </div>
    </div>
    <script src="<?= _A_::$app->router()->UrlTo('views/js/discount/discounts.js'); ?>"></script>