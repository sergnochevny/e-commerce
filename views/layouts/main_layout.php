<?php

use app\core\App;

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title><?= isset($meta['title']) ? $meta['title'] : ''; ?></title>
  <meta name="Description" content="<?= isset($meta['description']) ? $meta['description'] : ''; ?>">
  <meta name="KeyWords" content="<?= isset($meta['keywords']) ? $meta['keywords'] : ''; ?>">
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php if(isset($canonical_url)): ?>
    <link rel="canonical" href="<?= $canonical_url ?>"/>
  <?php endif; ?>
  <link rel="icon" href="<?= App::$app->router()->UrlTo('images/lf-logo.png'); ?>"/>
  <link rel="shortcut icon" href="<?= App::$app->router()->UrlTo('images/lf-logo.png'); ?>"/>
  <link rel="apple-touch-icon" href="<?= App::$app->router()->UrlTo('images/lf-logo.png'); ?>"/>
  <link rel="apple-touch-icon-precomposed" href="<?= App::$app->router()->UrlTo('images/lf-logo.png'); ?>"/>
  <link rel="apple-touch-startup-image" href="<?= App::$app->router()->UrlTo('images/lf-logo.png'); ?>"/>

  <style>
    .loader {
      background: #fff;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1000000000000;
    }

    .loader i {
      position: relative;
      left: 50vw;
      color: #000;
      top: 50vh;
      margin-left: -28px;
      margin-top: -28px;
    }
  </style>

  <link rel='stylesheet' type="text/css"
        href='<?= App::$app->router()->UrlTo('css/woocommerce-smallscreen.min.css'); ?>'
        media='only screen and (max-width: 768px)'/>

  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/font-face.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/offsets.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/bootstrap.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/font-awesome.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= App::$app->router()->UrlTo('css/simple-line-icons.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/webfont.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= App::$app->router()->UrlTo('css/jquery.smartmenus.bootstrap.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/style-theme.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= App::$app->router()->UrlTo('css/style-woocommerce.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= App::$app->router()->UrlTo('css/style-shortcodes.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/prettyPhoto.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= App::$app->router()->UrlTo('css/jquery-ui.min.css'); ?>'
        media='all'/>
  <link rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/owlcarousel/owl.carousel.min.css'); ?>">
  <link rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/owlcarousel/owl.theme.default.min.css'); ?>">
  <link rel="stylesheet" type="text/css"
        href="<?= App::$app->router()->UrlTo('css/tooltipster.bundle.min.css'); ?>"/>
  <link rel='stylesheet' id='just-style-css' href='<?= App::$app->router()->UrlTo('css/style.min.css'); ?>'/>
  <link href="<?= App::$app->router()->UrlTo('css/multiselect.min.css'); ?>" rel="stylesheet"/>

  <script type='text/javascript'
          src='<?= App::$app->router()->UrlTo('js/jquery3/jquery-3.1.1.min.js'); ?>'></script>
  <script type='text/javascript'
          src='<?= App::$app->router()->UrlTo('js/jquery3/jquery-migrate-3.0.0.min.js'); ?>'></script>
  <script type='text/javascript' src='<?= App::$app->router()->UrlTo('js/bootstrap.min.js'); ?>'></script>
  <script type='text/javascript' src='<?= App::$app->router()->UrlTo('js/jquery-ui.min.js'); ?>'></script>
  <script type='text/javascript' src='<?= App::$app->router()->UrlTo('js/jquery.smartmenus.min.js'); ?>'></script>
  <script type='text/javascript'
          src='<?= App::$app->router()->UrlTo('js/jquery.smartmenus.bootstrap.min.js'); ?>'></script>
  <script type='text/javascript'
          src='<?= App::$app->router()->UrlTo('js/jquery.prettyPhoto.min.js'); ?>'></script>
  <script src='<?= App::$app->router()->UrlTo('js/inputmask/jquery.inputmask.bundle.min.js'); ?>'
          type="text/javascript"></script>
  <script type='text/javascript'
          src='<?= App::$app->router()->UrlTo('js/owlcarousel/owl.carousel.min.js'); ?>'></script>
  <script type="text/javascript"
          src="<?= App::$app->router()->UrlTo('js/tooltipster.bundle.min.js'); ?>"></script>
  <script type='text/javascript'
          src="<?= App::$app->router()->UrlTo('js/jqmobile/jquery.mobile.custom.min.js'); ?>"></script>
  <script src="<?= App::$app->router()->UrlTo('js/multiselect.min.js'); ?>"></script>
  <script type='text/javascript' src='<?= App::$app->router()->UrlTo('js/search/search.min.js'); ?>'></script>
  <script type='text/javascript' src='<?= App::$app->router()->UrlTo('js/script.min.js'); ?>'></script>
</head>
<body class="woocommerce woocommerce-page">
<input type="hidden" id="base_url" value="<?= App::$app->router()->UrlTo('/'); ?>">

<?php include("loader.php"); ?>

<div class="scroll">
  <div class="site-container">
    <div class="main-content main-content-shop">
      <?php include(APP_PATH . "/views/header.php"); ?>
      <?= isset($content) ? $content : ''; ?>
    </div>
  </div>

  <footer class="site-footer">
    <?php include(APP_PATH . '/views/footer.php') ?>
    <?php include(APP_PATH . '/views/copyright.php') ?>
  </footer>
  <?php if(isset($cart_enable)) { ?>
    <a data-waitloader href="<?= App::$app->router()->UrlTo('cart'); ?>" id="cart" rel="nofollow" class="cart-subtotal">
      <i class="simple-icon-handbag"></i>
      <span class="topnav-label">
        <span id="cart_amount" class="amount">
          $0.00
        </span>
      </span>
    </a>
    <script type="text/javascript">
      (function ($) {
        $('span#cart_amount').load('<?= App::$app->router()->UrlTo('cart/amount');?>');
      })(window.jQuery || window.$);
    </script>
  <?php } ?>
</div>
</body>
</html>