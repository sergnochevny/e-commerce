<ul role="group" class="dropdown-menu" id="sm-14573591911186943-2" aria-hidden="true"
    aria-labelledby="sm-14573591911186943-1" aria-expanded="false"
    style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">

    <li class="menu-item menu-item-type-post_type menu-item-object-product">
        <a data-waitloader title="Specials" class="shop_menu" href="<?= _A_::$app->router()->UrlTo('shop/specials')?>">Specials</a>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-product">
        <a data-waitloader title="What's New" href="<?= _A_::$app->router()->UrlTo('shop/last');?>" class="has-submenu" id="sm-14573591911186943-3" aria-haspopup="true"
           aria-controls="sm-14573591911186943-4" aria-expanded="false">What's New</a>
        <ul role="group" class="dropdown-menu sm-nowrap" id="sm-14573591911186943-4" aria-hidden="true"
            aria-labelledby="sm-14573591911186943-3" aria-expanded="false"
            style="width: auto; display: none; top: auto; left: 0px; margin-left: -171.203px; margin-top: -35px; min-width: 10em; max-width: 20em;">
            <?= $menu_new_category;?>
        </ul>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-product">
        <a data-waitloader title="Shop by Pattern Type" href="#" class="has-submenu" id="sm-14573591911186943-5" aria-haspopup="true"
           aria-controls="sm-14573591911186943-6" aria-expanded="false">Shop by Pattern Type</a>
        <ul role="group" class="dropdown-menu sm-nowrap" id="sm-14573591911186943-6" aria-hidden="true"
            aria-labelledby="sm-14573591911186943-5" aria-expanded="false"
            style="width: auto; display: none; top: auto; left: 0px; margin-left: -140.891px; margin-top: -35px; min-width: 10em; max-width: 20em;">
            <?= $menu_patterns;?>
        </ul>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-product">
        <a data-waitloader title="Shop by Category" href="#" class="has-submenu" id="sm-14573591911186943-7" aria-haspopup="true"
           aria-controls="sm-14573591911186943-8" aria-expanded="false">Shop by Category</a>
        <ul role="group" class="dropdown-menu sm-nowrap" id="sm-14573591911186943-8" aria-hidden="true"
            aria-labelledby="sm-14573591911186943-7" aria-expanded="false"
            style="width: auto; display: none; top: auto; left: 0px; margin-left: -217.5px; margin-top: -35px; min-width: 10em; max-width: 20em;">
            <?= $menu_all_category;?>
        </ul>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-product">
        <a data-waitloader title="Shop by Fabric Designer" href="#" class="has-submenu" id="sm-14573591911186943-9" aria-haspopup="true"
           aria-controls="sm-14573591911186943-10" aria-expanded="false">Shop by Fabric Designer</a>
        <ul role="group" class="dropdown-menu sm-nowrap" id="sm-14573591911186943-10" aria-hidden="true"
            aria-labelledby="sm-14573591911186943-9" aria-expanded="false"
            style="width: auto; display: none; top: auto; left: 0px; margin-left: -187.422px; margin-top: -50px; min-width: 10em; max-width: 20em;">
            <?= $menu_manufacturers;?>
        </ul>
    </li>
</ul>