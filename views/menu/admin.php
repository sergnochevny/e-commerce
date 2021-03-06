<?php

use app\core\App;
use classes\helpers\AdminHelper;

?>
<?php if(AdminHelper::is_logged()): ?>
  <button type="button" class="navbar-toggle toggle-menu" data-toggle="collapse"
          data-target=".site-navigation .navbar-collapse" id="menu-button">
    <div class="hamburger">
      <div class="inner"></div>
    </div>
  </button>
  <div>
    <div class="col-xs-12 pull-right navbar-collapse collapse navbar-collapse-top admin-menubar">
      <ul id="menu-header-menu" class="site-menu nav navbar-nav navbar-right">
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a title="Products" aria-haspopup="true" class="has-submenu" href="javascript:void(0);">Products<span
              class="caret"></span></a>
          <ul role="group" class="dropdown-menu" aria-hidden="true" aria-expanded="false"
              style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Overview"
                 href="<?= App::$app->router()->UrlTo('product'); ?>">Overview</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Categories"
                 href="<?= App::$app->router()->UrlTo('categories'); ?>">Types</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Manufacturers"
                 href="<?= App::$app->router()->UrlTo('manufacturers'); ?>">Manufacturers</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Colors"
                 href="<?= App::$app->router()->UrlTo('colors'); ?>">Colors</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Patterns"
                 href="<?= App::$app->router()->UrlTo('patterns'); ?>">Patterns</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Clearance"
                 href="<?= App::$app->router()->UrlTo('clearance'); ?>">Clearance</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Synonyms"
                 href="<?= App::$app->router()->UrlTo('synonyms'); ?>">Synonyms</a>
            </li>
          </ul>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a title="Notice" aria-haspopup="true" class="has-submenu" href="javascript:void(0);">Notice<span
              class="caret"></span></a>
          <ul role="group" class="dropdown-menu" aria-hidden="true" aria-expanded="false"
              style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="On Home Page"
                 href="<?= App::$app->router()->UrlTo('info/edit', ['method' => 'home']); ?>">On Home Page</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="On Product Page"
                 href="<?= App::$app->router()->UrlTo('info/edit', ['method' => 'product']); ?>">On Product Page</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="On Cart"
                 href="<?= App::$app->router()->UrlTo('info/edit', ['method' => 'cart']); ?>">On Cart</a>
            </li>
          </ul>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Discounts"
             href="<?= App::$app->router()->UrlTo('discount'); ?>">Discounts</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Users" href="<?= App::$app->router()->UrlTo('users'); ?>">Users</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a title="Blog" aria-haspopup="true" class="has-submenu" href="javascript:void(0);">Blog<span class="caret"></span></a>
          <ul role="group" class="dropdown-menu" aria-hidden="true" aria-expanded="false"
              style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Blog Overview"
                 href="<?= App::$app->router()->UrlTo('blog'); ?>">Overview</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-product">
              <a data-waitloader data-link title="Blog Categories"
                 href="<?= App::$app->router()->UrlTo('blogcategory'); ?>">Categories</a>
            </li>
          </ul>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="All Orders" href="<?= App::$app->router()->UrlTo('orders'); ?>">Orders</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="System Settings"
             href="<?= App::$app->router()->UrlTo('settings/edit'); ?>">Settings</a>
        </li>
      </ul>
    </div>
  </div>
<?php endif; ?>