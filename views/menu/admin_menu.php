<div class="col-md-10 col-lg-10">
    <div class="navbar-collapse collapse navbar-collapse-top">
        <ul id="menu-header-menu" class="site-menu nav navbar-nav navbar-right">
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (!is_null(_A_::$app->session('_a'))) { ?>
                    <a title="Products"  aria-haspopup="true" class="has-submenu" href="#">Products<span class="caret"></span></a>
                    <ul role="group" class="dropdown-menu" aria-hidden="true" aria-expanded="false" style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a data-waitloader data-link title="Overview" href="<?= _A_::$app->router()->UrlTo('product');?>">Overview</a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a data-waitloader data-link title="Categories" href="<?= _A_::$app->router()->UrlTo('categories');?>">Categories</a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a data-waitloader data-link title="Manufacturers" href="<?= _A_::$app->router()->UrlTo('manufacturers');?>">Manufacturers</a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a data-waitloader data-link title="Colors" href="<?= _A_::$app->router()->UrlTo('colours');?>">Colours</a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a data-waitloader data-link title="Colors" href="<?= _A_::$app->router()->UrlTo('patterns');?>">Patterns</a>
                        </li>
                    </ul>
                <?php } ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (!is_null(_A_::$app->session('_a'))) {
                    echo '<a data-link title="" href="'._A_::$app->router()->UrlTo('discount').'">Discounts</a>';
                }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                    if (!is_null(_A_::$app->session('_a'))) {
                        echo '<a data-link title="" href="'._A_::$app->router()->UrlTo('users').'">Users</a>';
                    }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                if (!is_null(_A_::$app->session('_a'))) { ?>
                    <a title="Blog"  aria-haspopup="true" class="has-submenu" href="#">Blog<span class="caret"></span></a>
                    <ul role="group" class="dropdown-menu" aria-hidden="true" aria-expanded="false" style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a data-waitloader data-link title="Blog Overview" href="<?= _A_::$app->router()->UrlTo('blog');?>">Overview</a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-product">
                            <a data-waitloader data-link title="Blog Categories" href="<?= _A_::$app->router()->UrlTo('blogcategory');?>">Categories</a>
                        </li>
                    </ul>
                <?php } ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                    if (!is_null(_A_::$app->session('_a'))) {
                        echo '<a data-link title="" href="'._A_::$app->router()->UrlTo('comments/').'">Comments</a>';
                    }
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <?php
                    if (!is_null(_A_::$app->session('_a'))) {
                        echo '<a data-link title="" href="'._A_::$app->router()->UrlTo('orders').'">Orders</a>';
                    }
                ?>
            </li>
        </ul>
    </div>
</div>
