<?php

use app\core\App;

/**
 * @var \app\core\Template $this
 */
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

  <link rel="icon" href="<?= App::$app->router()->UrlTo('images/favicon.png'); ?>"/>
  <link rel="shortcut icon" href="<?= App::$app->router()->UrlTo('images/favicon.png'); ?>"/>
  <link rel="apple-touch-icon" href="<?= App::$app->router()->UrlTo('images/favicon.png'); ?>"/>
  <link rel="apple-touch-icon-precomposed" href="<?= App::$app->router()->UrlTo('images/favicon.png'); ?>"/>
  <link rel="apple-touch-startup-image" href="<?= App::$app->router()->UrlTo('images/favicon.png'); ?>"/>

  <style>
    .loader {background: #fff; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000000000000;}
    .loader i {position: relative; left: 50vw; color: #000; top: 50vh; margin-left: -28px; margin-top: -28px;}
  </style>

  <?php
  $this->registerCSSFile(App::$app->router()->UrlTo('css/woocommerce-smallscreen.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/font-face.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/offsets.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/bootstrap.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/font-awesome.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/simple-line-icons.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/webfont.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/jquery.smartmenus.bootstrap.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/style-theme.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/style-woocommerce.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/style-shortcodes.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/prettyPhoto.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/jquery-ui.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/owlcarousel/owl.carousel.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/owlcarousel/owl.theme.default.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/tooltipster.bundle.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/style.min.css'));
  $this->registerCSSFile(App::$app->router()->UrlTo('css/multiselect.min.css'));

  $this->registerJSFile(App::$app->router()->UrlTo('js/jquery3/jquery-3.1.1.min.js'), 0);

  $this->registerJSFile(App::$app->router()->UrlTo('js/jquery3/jquery-migrate-3.0.0.min.js'),1);

  $this->registerJSFile(App::$app->router()->UrlTo('js/bootstrap.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/jquery-ui.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/jquery.smartmenus.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/jquery.smartmenus.bootstrap.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/jquery.prettyPhoto.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/inputmask/jquery.inputmask.bundle.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/owlcarousel/owl.carousel.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/tooltipster.bundle.min.js'), 2);
  $this->registerJSFile(App::$app->router()->UrlTo('js/jqmobile/jquery.mobile.custom.min.js'), 2);

  $this->registerJSFile(App::$app->router()->UrlTo('js/multiselect.min.js'), 3);
  $this->registerJSFile(App::$app->router()->UrlTo('js/search/search.min.js'), 3);
  $this->registerJSFile(App::$app->router()->UrlTo('js/script.min.js'), 3);

  ?>
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
  <?php if(isset($cart_enable)) : ?>
    <a data-waitloader href="<?= App::$app->router()->UrlTo('cart'); ?>" id="cart" rel="nofollow" class="cart-subtotal">
      <i class="simple-icon-handbag"></i>
      <span class="topnav-label">
        <span id="cart_amount" class="amount">
          $0.00
        </span>
      </span>
    </a>
    <?php
    $this->registerJS(
      "(function ($) {
          $('span#cart_amount').load('" . App::$app->router()->UrlTo('cart/amount') . "');
       })(window.jQuery || window.$);
       ");
    ?>
  <?php endif; ?>
</div>

<?= $this->renderLinks(); ?>

</body>
</html>