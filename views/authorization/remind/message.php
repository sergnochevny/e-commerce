<?php

use app\core\App;

?>
<html xmlns="http://www.w3.org/1999/xhtml"
      class="js_active">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?= App::$app->keyStorage()->system_site_name; ?></title>
  <meta name="KeyWords" content="<?= App::$app->keyStorage()->system_site_name; ?>">
  <meta name="Description" content="<?= App::$app->keyStorage()->system_site_name; ?>">
  <link charset="UTF-8" rel="icon" href="<?= App::$app->router()->UrlTo('images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="shortcut icon" href="<?= App::$app->router()->UrlTo('images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="apple-touch-icon" href="<?= App::$app->router()->UrlTo('images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="apple-touch-icon-precomposed"
        href="<?= App::$app->router()->UrlTo('images/lf-logo.png') ?>">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link charset="UTF-8" rel="apple-touch-startup-image" href="<?= App::$app->router()->UrlTo('images/lf-logo.png') ?>">
  <link charset="UTF-8" rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/woocommerce-smallscreen.min.css') ?>"
        type="text/css" media="only screen and (max-width: 768px)">
  <link charset="UTF-8" rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/bootstrap.min.css') ?>"
        type="text/css" media="all">
  <link charset="UTF-8" rel="stylesheet" id="just-smartmenu-css"
        href="<?= App::$app->router()->UrlTo('css/jquery.smartmenus.bootstrap.min.css') ?>" type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/font-awesome.min.scss') ?>"
        type="text/css" media="all">
  <link charset="UTF-8" rel="stylesheet"
        href="<?= App::$app->router()->UrlTo('css/simple-line-icons.min.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/webfont.min.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/style-theme.min.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet"
        href="<?= App::$app->router()->UrlTo('css/style-woocommerce.min.css') ?>"
  <!--        type="text/css"-->
  <!--        media="all">-->
  <link charset="UTF-8" rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/style-shortcodes.min.css') ?>"
        type="text/css"
        media="all">
  <link charset="UTF-8" rel="stylesheet" href="<?= App::$app->router()->UrlTo('css/prettyPhoto.min.css') ?>"
        type="text/css"
        media="all">

  <link charset="UTF-8" rel="stylesheet" id="just-style-css"
        href="<?= App::$app->router()->UrlTo('css/style.min.css') ?>"
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
                <a class="navbar-brand" href="<?= App::$app->router()->UrlTo('/'); ?>">
                  <div class="site-with-image">
                    <img class="site-logo" src="<?= App::$app->router()->UrlTo('images/logo.gif'); ?>" alt="">
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