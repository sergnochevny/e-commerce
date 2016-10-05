<body
  class="page page-id-1707 page-template-default woocommerce-cart woocommerce-page header-large ltr sticky-header-yes wpb-js-composer js-comp-ver-4.11.1 vc_responsive small-sticky">


<link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>' type='text/css'
      media='all'/>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content main-content-shop">
    <div id="cart_main_container" class="container">
      <?= isset($content) ? $content : ''; ?>
    </div>
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
      <a id="confirm_action">
        <input type="button" value="Yes confirm" class="button"/>
      </a>
      <a id="confirm_no">
        <input type="button" value="No" class="button"/>
      </a>
    </div>
  </div>
</div>
<input type="hidden" id="base_url" value="<?= _A_::$app->router()->UrlTo('/'); ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/cart/container.js'); ?>' type="text/javascript"></script>

