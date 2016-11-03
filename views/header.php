<header class="site-header">
  <div class="header-topnav">
    <div class="container">
      <div class="row">
        <div class="col-md-5 hidden-xs hidden-sm">
          <span class="welcome-message">Textiles and Fabric Online</span>
        </div>
        <div class="col-md-7">
          <ul class="nav navbar-nav navbar-right">
            <?php if(!isset($my_account_admin_menu)) { ?>
              <li class="dropdown">
                <a data-waitloader href="#" rel="nofollow" class="dropdown-toggle" data-toggle="dropdown">
                  <i class=" drip-icon-search"></i>
                  <span class="topnav-label hidden-xs">Search</span>
                </a>
                <ul class="dropdown-menu topnav-search-dropdown">
                  <li>
                    <form id="f_search" role="search" method="post" class="woocommerce-product-search"
                          action="<?= _A_::$app->router()->UrlTo('shop'); ?>">
                      <label class="screen-reader-text" for="s">Search for:</label>
                      <input id="search" type="search" class="search-field"
                             placeholder="Search Products&hellip;" value="<?= isset($search_str) ? $search_str : '' ?>" name="s"
                             title="Search for:"/>
                      <input id="b_search" type="button" value="Search"/>
                    </form>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <?= isset($my_account_admin_menu) ? $my_account_admin_menu : '' ?>
            <?= isset($my_account_user_menu) ? $my_account_user_menu : '' ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <nav class="site-navigation navbar navbar-default " role="navigation" itemscope="itemscope">
    <div class="container">
      <div class="header-block">
        <div class="row">
          <div class="col-md-2 col-lg-2">
            <div class="navbar-header">
              <div class="navbar-toggle navbar-icon toggle-menu" data-toggle="collapse"
                      data-target=".site-navigation .navbar-collapse" id="menu-button">
                <div class="hamburger"><div class="inner"></div></div>
              </div>
              <a data-waitloader class="navbar-brand" href="<?= _A_::$app->router()->UrlTo('/'); ?>">
                <div class="site-with-image">
                  <img class="site-logo" src="<?= _A_::$app->router()->UrlTo('views/images/logo.png'); ?>" alt=""/>
                </div>
              </a>
            </div>
          </div>
          <?= $menu ?>
        </div>
      </div>
    </div>
  </nav>
</header>
