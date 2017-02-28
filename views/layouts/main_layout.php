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
  <link rel="icon" href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
  <link rel="shortcut icon" href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
  <link rel="apple-touch-icon" href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
  <link rel="apple-touch-icon-precomposed" href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
  <link rel="apple-touch-startup-image" href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
  <link rel='stylesheet' type="text/css"
        href='<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('views/css/woocommerce-smallscreen.css'); ?>'
        media='only screen and (max-width: 768px)'/>

  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/font-face.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/offsets.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/bootstrap.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/font-awesome.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('views/css/simple-line-icons.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/webfont.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('views/css/jquery.smartmenus.bootstrap.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/style-theme.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('views/css/style-woocommerce.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css"
        href='<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('views/css/style-shortcodes.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/prettyPhoto.min.css'); ?>'/>
  <link rel='stylesheet' type="text/css" href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>'
        media='all'/>
  <link rel="stylesheet" href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/owlcarousel/owl.carousel.css'); ?>">
  <link rel="stylesheet" href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/owlcarousel/owl.theme.default.min.css'); ?>">
  <link rel="stylesheet" type="text/css"
        href="<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('views/css/tooltipster.bundle.min.css'); ?>"/>
  <link rel='stylesheet' id='just-style-css' href='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/css/style.min.css'); ?>'/>

  <script type='text/javascript'
          src='<?= /** @noinspection PhpUndefinedMethodInspection */
            _A_::$app->router()->UrlTo('views/js/jquery2/jquery-2.2.4.min.js'); ?>'></script>
  <script type='text/javascript' src='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>
  <script type='text/javascript'
          src='<?= /** @noinspection PhpUndefinedMethodInspection */
            _A_::$app->router()->UrlTo('views/js/jquery2/jquery-migrate-1.4.1.min.js'); ?>'></script>
  <script type='text/javascript' src='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/js/bootstrap.min.js'); ?>'></script>
  <script type='text/javascript' src='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/js/jquery.smartmenus.min.js'); ?>'></script>
  <script type='text/javascript'
          src='<?= /** @noinspection PhpUndefinedMethodInspection */
            _A_::$app->router()->UrlTo('views/js/jquery.smartmenus.bootstrap.min.js'); ?>'></script>
  <script type='text/javascript'
          src='<?= /** @noinspection PhpUndefinedMethodInspection */
            _A_::$app->router()->UrlTo('views/js/jquery.prettyPhoto.min.js'); ?>'></script>
  <script src='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/js/inputmask/jquery.inputmask.bundle.min.js'); ?>'
          type="text/javascript"></script>
  <script type='text/javascript'
          src='<?= /** @noinspection PhpUndefinedMethodInspection */
            _A_::$app->router()->UrlTo('views/js/owlcarousel/owl.carousel.min.js'); ?>'></script>
  <script type="text/javascript"
          src="<?= /** @noinspection PhpUndefinedMethodInspection */
            _A_::$app->router()->UrlTo('views/js/tooltipster.bundle.min.js'); ?>"></script>
  <script type='text/javascript'
          src="<?= /** @noinspection PhpUndefinedMethodInspection */
            _A_::$app->router()->UrlTo('views/js/jqmobile/jquery.mobile.custom.min.js'); ?>"></script>
  <script type='text/javascript' src='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/js/search/search.js'); ?>'></script>
  <script type='text/javascript' src='<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('views/js/script.min.js'); ?>'></script>
</head>
<body class="woocommerce woocommerce-page">
<input type="hidden" id="base_url" value="<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('/'); ?>">

<div class="scroll">
  <div class="site-container">
    <div class="main-content main-content-shop">
      <?php include "views/header.php"; ?>
      <?= isset($content) ? $content : ''; ?>
    </div>
  </div>

  <footer class="site-footer">
    <?php include('views/footer.php') ?>
    <?php include('views/copyright.php') ?>
  </footer>
  <?php if(isset($cart_enable)) { ?>
    <a href="<?= /** @noinspection PhpUndefinedMethodInspection */
      _A_::$app->router()->UrlTo('cart'); ?>" id="cart" rel="nofollow" class="cart-subtotal">
      <i class="simple-icon-handbag"></i>
      <span class="topnav-label">
        <span id="cart_amount" class="amount">
          $0.00
        </span>
      </span>
    </a>
    <script type="text/javascript">
      (function ($) {
        $('span#cart_amount').load('<?= /** @noinspection PhpUndefinedMethodInspection */_A_::$app->router()->UrlTo('cart/amount');?>');
      })(jQuery);
    </script>
  <?php } ?>
</div>
</body>
</html>