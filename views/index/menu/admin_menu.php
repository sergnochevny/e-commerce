<div class="col-md-10 col-lg-10">
    <div class="navbar-collapse collapse navbar-collapse-top">
        <ul id="menu-header-menu" class="site-menu nav navbar-nav navbar-right">
            <!--<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item active">
										<a title="" href="index">Home</a>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page">
										<a title="" href="about">About us</a>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children dropdown">
										<a title="" href="#" class="has-submenu" id="sm-14556147971389604-1" aria-haspopup="true" aria-controls="sm-14556147971389604-2" aria-expanded="false">Shop <span class="caret"></span></a>
										<ul role="menu" class=" dropdown-menu" style="z-index: 101;">
                                            <?php
                                            echo $menu_list;
                                            ?>
										</ul>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page">
										<a title="" href="blog">Blog</a>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page">
										<a title="" href="newsletter">Newsletter</a>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page">
										<a title="" href="service">Service</a>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page">
										<a title="" href="contact">Contact</a>
									</li>-->
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (isset($_SESSION['_a'])) {
                    echo '<a title="" href="'.$base_url.'/admin_home">Products</a>';
                }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (isset($_SESSION['_a'])) {
                    echo '<a title="" href="'.$base_url.'/discounts">discounts</a>';
                }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (isset($_SESSION['_a'])) {
                    echo '<a title="" href="'.$base_url.'/categories">categories</a>';
                }
                ?>

            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (isset($_SESSION['_a'])) {
                    echo '<a title="" href="'.$base_url.'/users">Users</a>';
                }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (isset($_SESSION['_a'])) {
                    ?>
                    <a title="Blog"  aria-haspopup="true" class="has-submenu" href="#">Blog<span class="caret"></span></a>
                    <ul role="group" class="dropdown-menu" aria-hidden="true" aria-expanded="false" style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a title="Blog Posts" href="<?php echo $base_url;?>/admin_blog">Overview</a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a title="Blog Categories" href="<?php echo $base_url;?>/admin_blog_categories">Categories</a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (isset($_SESSION['_a'])) {
                    echo '<a title="" href="'.$base_url.'/admin_comments">Comments</a>';
                }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (isset($_SESSION['_a'])) {
                    echo '<a title="" href="'.$base_url.'/orders_history">Orders</a>';
                }
                ?>
            </li>
        </ul>
    </div>
</div>
