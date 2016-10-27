<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= isset($meta['page_Name']) ? $meta['page_Name'] : ''; ?></title>

    <meta name="KeyWords" content="<?= isset($meta['page_KeyWords']) ? $meta['page_KeyWords'] : ''; ?>">
    <meta name="Description" content="<?= isset($meta['page_Description']) ? $meta['page_Description'] : ''; ?>">

    <link rel="icon" href="<?= _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
    <link rel="shortcut icon" href="<?= _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
    <link rel="apple-touch-icon" href="<?= _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
    <link rel="apple-touch-icon-precomposed" href="<?= _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>

    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-startup-image" href="<?= _A_::$app->router()->UrlTo('views/images/lf-logo.png'); ?>"/>
    <link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/woocommerce-layout.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/woocommerce-smallscreen.css'); ?>'
          media='only screen and (max-width: 768px)'/>

<!--    <link rel='stylesheet' type="text/css" href='--><? //= _A_::$app->router()->UrlTo('views/css/woocommerce.css'); ?><!--'/>-->
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/bootstrap.min.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/font-awesome.min.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/js_composer.min.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/simple-line-icons.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/webfont.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/jquery.smartmenus.bootstrap.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/style-theme.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/style-woocommerce.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/style-shortcodes.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/prettyPhoto.min.css'); ?>'/>
    <link rel='stylesheet' type="text/css" href='<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>' media='all'/>
    <link rel='stylesheet' id='just-style-css' href='<?= _A_::$app->router()->UrlTo('views/css/style.css'); ?>'/>

    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery_11_3.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery-migrate.min.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/bootstrap.min.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery.smartmenus.min.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery.smartmenus.bootstrap.min.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery.prettyPhoto.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/search/search.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/js_composer_front.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jQuery-slimScroll-1.3.8/jquery.slimscroll.min.js'); ?>'></script>
    <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/script.js'); ?>'></script>

  </head>
  <body class="woocommerce woocommerce-page">
    <div class="scroll">
      <div class="site-container">
        <div class="main-content main-content-shop">
          <?php include "views/header.php"; ?>
          <?= isset($content) ? $content : ''; ?>
          <input type="hidden" id="base_url" value="<?= _A_::$app->router()->UrlTo('/'); ?>">
        </div>
      </div>

      <footer class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
        <?php include('views/footer.php') ?>
        <div class="footer-credit">
          <div class="container">
            <div class="copyright">
              <div class="row">
                <div class="footer-credit-left col-md-6 col-xs-12">
                  <p>2016 Copyright &copy; ILuvFabrix</p>
                </div>
                <div class="footer-credit-right col-md-6 col-xs-12">
                  <p><img src="<?= _A_::$app->router()->UrlTo('views/images/temp/payment.png'); ?>" alt=""></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <?php if(isset($cart_enable)) { ?>
        <a href="<?= _A_::$app->router()->UrlTo('cart'); ?>" id="cart" rel="nofollow" class="cart-subtotal">
          <i class="simple-icon-handbag"></i>
          <span class="topnav-label">
            <span id="cart_amount" class="amount">
                $0.00
            </span>
          </span>
        </a>
        <script type="text/javascript">
          (function ($) {
            $('span#cart_amount').load('<?= _A_::$app->router()->UrlTo('cart/amount');?>');
          })(jQuery);
        </script>
      <?php } ?>
    </div>
  </body>
</html>