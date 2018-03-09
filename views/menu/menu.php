<?php

use app\core\App;
use classes\helpers\UserHelper;

?>
<div class="row menu-wrap">
  <div class="pull-right text-right button-ask top-menu <?= UserHelper::is_logged() ? '' : 'login'; ?>">
    <a class="button" title="Ask a Question"
       href="mailto:<?= App::$app->keyStorage()->system_info_email . '?subject=' . rawurlencode('RE: Inquiry for Iluvfabrix'); ?>">
      <span>Ask a Question</span>
      <i class="fa fa-question" aria-hidden="true"></i>
    </a>
  </div>

  <button type="button" class="navbar-toggle toggle-menu" data-toggle="collapse"
          data-target=".site-navigation .navbar-collapse" id="menu-button">
    <div class="hamburger">
      <div class="inner"></div>
    </div>
  </button>

  <div class="col-xs-12 pull-right navbar-collapse collapse navbar-collapse-top top-menu">
    <div class="row">
      <ul id="menu-header-menu" class="site-menu nav navbar-nav">
        <li
          class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item active">
          <a data-waitloader data-link title="Home" href="<?= App::$app->router()->UrlTo('/') ?>">Home</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Shop" href="<?= App::$app->router()->UrlTo('shop'); ?>">Shop</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Specials"
             href="<?= App::$app->router()->UrlTo('shop/specials', null, 'specials') ?>">Specials</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Clearance" href="<?= App::$app->router()->UrlTo('clearance/view') ?>">Clearance</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Matches"
             href="<?= App::$app->router()->UrlTo('estimator') ?>">Estimator</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Matches"
             href="<?= App::$app->router()->UrlTo('matches') ?>">Matches</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Fabric Favorites"
             href="<?= App::$app->router()->UrlTo('favorites'); ?>">
            <span class="topnav-label">Fabric Favorites</span>
          </a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Recommendations"
             href="<?= App::$app->router()->UrlTo('recommends'); ?>">
            <span class="topnav-label">Recommendations</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
