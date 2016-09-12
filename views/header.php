<header class="site-header">
    <div class="header-topnav">
        <div class="container">
            <div class="row">
                <div class="col-md-5 hidden-xs hidden-sm">
                    <span class="welcome-message">Textiles and Fabric Online</span>
                </div>
                <div class="col-md-7">
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li class="dropdown">
                            <a href="#" rel="nofollow" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="drip-icon-heart"></i>
                                <span class="topnav-label hidden-xs">Social</span>
                            </a>
                            <ul class="dropdown-menu topnav-social-dropdown social-connect" role="menu">
                                <li><a href="#" rel="nofollow"><i class="fa fa-facebook"></i> Facebook</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-twitter"></i> Twitter</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-google-plus"></i> Google Plus</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-instagram"></i> Instagram</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-rss"></i> Rss</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-envelope-o"></i> E Mail</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-youtube"></i> Youtube</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-flickr"></i> Flickr</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-linkedin"></i> Linkedin</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-pinterest"></i> Pinterest</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-dribbble"></i> Dribbble</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-github"></i> Github</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-lastfm"></i> Lastfm</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-vimeo-square"></i> Vimeo</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-tumblr"></i> Tumblr</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-soundcloud"></i> Soundcloud</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-behance"></i> Behance</a></li>
                                <li><a href="#" rel="nofollow"><i class="fa fa-deviantart"></i> Deviantart</a></li>
                            </ul>
                        </li>-->

                        <?php if (!isset($my_account_admin_menu)){?>
                        <li class="dropdown">
                            <a href="#" rel="nofollow" class="dropdown-toggle" data-toggle="dropdown">
                                <i class=" drip-icon-search"></i>
                                <span class="topnav-label hidden-xs">Search</span>
                            </a>
                            <ul class="dropdown-menu topnav-search-dropdown">
                                <li>
                                    <form id="f_search" role="search" method="post" class="woocommerce-product-search"
                                          action="<?php echo _A_::$app->router()->UrlTo('shop'); ?>">
                                        <label class="screen-reader-text" for="s">Search for:</label>
                                        <input id="search" type="search" class="search-field"
                                               placeholder="Search Products&hellip;" value="<?php echo isset($search)?$search:''?>" name="s"
                                               title="Search for:"/>
                                        <input id="b_search" type="button" value="Search"/>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <?php }?>

                        <?php echo isset($my_account_admin_menu)?$my_account_admin_menu:''?>
                        <?php echo isset($my_account_user_menu)?$my_account_user_menu:''?>
                        <!--<li class="dropdown open">
                            <a href="#" rel="nofollow" class="dropdown-toggle cart-subtotal" data-toggle="dropdown" aria-expanded="true">
                                <i class="simple-icon-handbag"></i>
                                <span class="topnav-label">
                                    <span class="amount">
                                        $0.00
                                    </span>
                                </span>
                            </a>
                            <!--<ul class="dropdown-menu topnav-minicart-dropdown">
                                <li>
                                    <div class="widget woocommerce widget_shopping_cart"><div class="widget_shopping_cart_content"></div></div>
                                </li>
                            </ul>
                        </li>-->
                    </ul>
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
                            <button type="button" class="navbar-toggle navbar-icon toggle-menu" data-toggle="collapse"
                                    data-target=".site-navigation .navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <i class="fa fa-navicon"></i>
                            </button>
                            <a class="navbar-brand" href="<?php _A_::$app->router()->UrlTo('/');?>">
                                <div class="site-with-image"><img class="site-logo" src="<?php _A_::$app->router()->UrlTo('views/images/logo.gif');?>" alt=""/>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php echo $menu ?>
                </div>
            </div>
        </div>
    </nav>
</header>
