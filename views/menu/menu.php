<div class="row pull-right">
  <div class="col-xs- col-xs-pull-8 navbar-toggle navbar-icon toggle-menu" data-toggle="collapse"
       data-target=".site-navigation .navbar-collapse" id="menu-button">
    <div class="row pull-right">
      <div class="hamburger">
        <div class="inner"></div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 navbar-collapse collapse navbar-collapse-top top-menu">
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
          <a data-waitloader data-link title="Blog" aria-haspopup="true" class="has-submenu"
             href="<?= _A_::$app->router()->UrlTo('blog/view') ?>">Blog<span class="caret"></span></a>
          <?= isset($blog_menu) ? $blog_menu : ''; ?>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Newsletter" href="<?= _A_::$app->router()->UrlTo('newsletter') ?>">Newsletter</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Service" href="<?= _A_::$app->router()->UrlTo('service') ?>">Service</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="About us" href="<?= _A_::$app->router()->UrlTo('about') ?>">About us</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Contact" href="<?= _A_::$app->router()->UrlTo('contact') ?>">Contact</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Matches" href="<?= _A_::$app->router()->UrlTo('matches') ?>">Matches</a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page">
          <a data-waitloader data-link title="Matches" href="<?= _A_::$app->router()->UrlTo('estimate') ?>">Estimate</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="col-md-push-12 text-right button-ask top-menu">
    <a class="button" title="Ask a Question" href="mailto:info@iluvfabrix.com">
      <span>Ask a Question</span>
      <i class="fa fa-question" aria-hidden="true"></i>
    </a>
  </div>
</div>
