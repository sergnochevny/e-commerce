<header class="site-header">
  <div class="header-topnav">
    <div class="container">
      <div class="row">
        <div class="col-md-4 hidden-xs hidden-sm">
          <span class="welcome-message">Textiles and Fabric Online</span>
        </div>
        <div class="col-md-8">
          <ul class="nav navbar-nav navbar-right">
            <?php if(!isset($my_account_admin_menu)) { ?>
              <li class="dropdown">
                <a href="javascript:void(0)" rel="nofollow" class="dropdown-toggle search-call" style="padding-right: 0"
                   data-toggle="dropdown">
                  <i class="fa fa-2x fa-search" aria-hidden="true"></i>
                  <form id="f_search" role="search" method="post" class="header-search hidden"
                        action="<?= _A_::$app->router()->UrlTo('shop'); ?>">
                    <label class="screen-reader-text" for="s">Search for:</label>
                    <input id="search" type="search" class="search-field"
                           placeholder="Search Products&hellip;"
                           value="<?= isset($search_str) ? $search_str : '' ?>" name="s"
                           title="Search for:"/>
                    <input id="b_search" type="button" value="Search"/>
                  </form>
                </a>
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
      <div class="header-block<?= (isset($my_account_admin_menu))?' wo_button':''?>">
        <div class="col-logo">
          <div class="row">
            <div class="navbar-header">
              <a data-waitloader class="navbar-brand" href="<?= _A_::$app->router()->UrlTo('/'); ?>">
                <div class="site-with-image">
                  <img class="site-logo" src="<?= _A_::$app->router()->UrlTo('images/logo.png'); ?>" alt=""/>
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
