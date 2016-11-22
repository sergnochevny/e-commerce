<header class="site-header">
  <div class="header-topnav">
    <div class="container">
      <div class="row">
        <div class="col-md-4 hidden-xs hidden-sm">
          <span class="welcome-message">Textiles and Fabric Online</span>
        </div>
        <div class="col-md-8">
          <ul class="nav navbar-nav navbar-right">
            <?= isset($my_account_admin_menu) ? $my_account_admin_menu : '' ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <nav class="site-navigation navbar navbar-default " role="navigation" itemscope="itemscope">
    <div class="container">
      <div class="header-block">
        <div class="col-xs-2 col-md-2 col-lg-2">
          <div class="row">
            <div class="navbar-header">
              <a data-waitloader class="navbar-brand" href="<?= _A_::$app->router()->UrlTo('/'); ?>">
                <div class="site-with-image wo_button">
                  <img class="site-logo" src="<?= _A_::$app->router()->UrlTo('views/images/logo.png'); ?>" alt=""/>
                </div>
              </a>
            </div>
          </div>
        </div>
        <?= $menu ?>
      </div>
    </div>
  </nav>
</header>
