<div class="row menu-wrap">
  <div class="pull-right text-right button-ask top-menu <?= Controller_User::is_logged()?'':'login';?>">
    <a class="button" title="Ask a Question" href="mailto:<?= _A_::$app->keyStorage()->system_info_email; ?>">
      <span>Ask a Question</span>
      <i class="fa fa-question" aria-hidden="true"></i>
    </a>
  </div>
  <div class="col-xs-8 col-xs-pull-8 navbar-toggle navbar-icon toggle-menu" data-toggle="collapse"
       data-target=".site-navigation .navbar-collapse" id="menu-button">
    <div class="row pull-right">
      <div class="hamburger">
        <div class="inner"></div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 pull-right navbar-collapse collapse navbar-collapse-top top-menu">
    <div class="row">
      <ul id="menu-header-menu" class="site-menu nav navbar-nav">
        <li
          class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item active">
          <a data-waitloader data-link title="Home" href="<?= _A_::$app->router()->UrlTo('/') ?>">Home</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Shop" href="<?= _A_::$app->router()->UrlTo('shop'); ?>">Shop</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Specials" href="<?= _A_::$app->router()->UrlTo('shop/specials', null, 'specials') ?>">Specials</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Clearance" href="<?= _A_::$app->router()->UrlTo('clearance/view') ?>">Clearance</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Matches" href="<?= _A_::$app->router()->UrlTo('estimate') ?>">Estimator</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Matches" href="<?= _A_::$app->router()->UrlTo('matches') ?>">Matches</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Newsletter" href="<?= _A_::$app->router()->UrlTo('newsletter') ?>">Newsletter</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Service" href="<?= _A_::$app->router()->UrlTo('service') ?>">Service</a>
        </li>

        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a title="About" aria-haspopup="true" class="has-submenu" href="javascript:void(0);">About<span
              class="caret"></span></a>
          <ul role="group" class="dropdown-menu" aria-hidden="true" aria-expanded="false"
              style="width: 20em; display: none; top: auto; left: 0px; margin-left: -139.734px; margin-top: 0px; min-width: 10em; max-width: 20em;">
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
              <a data-waitloader data-link title="About us" href="<?= _A_::$app->router()->UrlTo('about') ?>">About Us</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
              <a data-waitloader data-link title="Contact Us" href="<?= _A_::$app->router()->UrlTo('contact') ?>">Contact Us</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
              <a data-waitloader data-link title="Blog" href="<?= _A_::$app->router()->UrlTo('blog/view') ?>">Blog</a>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</div>
