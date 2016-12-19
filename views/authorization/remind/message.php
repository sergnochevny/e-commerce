<html xmlns="http://www.w3.org/1999/xhtml"
      class="js_active">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?= _A_::$app->keyStorage()->system_site_name;?></title>
  <meta name="KeyWords" content="<?= _A_::$app->keyStorage()->system_site_name;?>">
  <meta name="Description" content="<?= _A_::$app->keyStorage()->system_site_name;?>">
  <link charset="UTF-8" rel="icon" href="<?= _A_::$app->router()->UrlTo('/views/images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="shortcut icon" href="<?= _A_::$app->router()->UrlTo('/views/images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="apple-touch-icon" href="<?= _A_::$app->router()->UrlTo('/views/images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="apple-touch-icon-precomposed"
        href="<?= _A_::$app->router()->UrlTo('/views/images/lf-logo.png') ?>">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link charset="UTF-8" rel="apple-touch-startup-image"
        href="<?= _A_::$app->router()->UrlTo('/views/images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="stylesheet"
        href="<?= _A_::$app->router()->UrlTo('/views/css/woocommerce-smallscreen.css') ?>"
        type="text/css" media="only screen and (max-width: 768px)">
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/bootstrap.min.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" id="just-smartmenu-css"
        href="<?= _A_::$app->router()->UrlTo('/views/css/jquery.smartmenus.bootstrap.css') ?>" type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/font-awesome.min.scss') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/simple-line-icons.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/webfont.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/style-theme.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/style-woocommerce.css') ?>"
<!--        type="text/css"-->
<!--        media="all">-->
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/style-shortcodes.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('/views/css/prettyPhoto.min.css') ?>"
        type="text/css"
        media="all">

  <link charset="UTF-8" rel="stylesheet" id="just-style-css"
        href="<?= _A_::$app->router()->UrlTo('/views/css/style.css') ?>"
        type="text/css" media="all">
</head>

<body
  class="page page-template-default woocommerce-account woocommerce-page header-large ltr">
<div class="site-container">
  <header class="site-header">
    <div class="header-topnav">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <span class="welcome-message">Upholstery Fabric. Textiles and Fabric Online.</span>
          </div>
        </div>
      </div>
    </div>
    <!-- top header -->
    <nav class="site-navigation navbar navbar-default " role="navigation" itemscope="itemscope"
         itemtype="http://schema.org/SiteNavigationElement">
      <div class="container">
        <div class="header-block">
          <div class="row">
            <div class="col-md-2 col-lg-2">
              <div class="navbar-header">
                <a class="navbar-brand" href="<?= _A_::$app->router()->UrlTo('/'); ?>">
                  <div class="site-with-image"><img class="site-logo"
                                                    src="<?= _A_::$app->router()->UrlTo('/views/images/logo.gif'); ?>"
                                                    alt="">
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <div class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <article class="page type-page status-publish entry">
            <div class="just-post col-xs-12">
              <div class="just-post-detail">
                <p>
                  To change the password , click the link charset="UTF-8" below. The link charset="UTF-8" is valid for
                  24 hours.
                  If you did not request to change the password , just ignore this message.
                </p>
                <p>
                  Change My Password:
                  <a href="<?= $remind_url ?>"><?= $remind_url ?></a>
                </p>
              </div>
            </div>

          </article>
        </div>
      </div>
    </div>
  </div>
  <footer id="colophon" class="site-footer" role="contentinfo" itemscope="itemscope"
          itemtype="http://schema.org/WPFooter">
    <div class="footer-credit">
      <div class="container">
        <div class="copyright">
          <div class="row">
            <div class="footer-credit-left col-md-6 col-xs-12">
              <p>2016 Copyright © ILuvFabrix</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>
</body>
</html>