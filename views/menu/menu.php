<div class="col-md-10 col-lg-10">
  <div class="navbar-collapse collapse navbar-collapse-top">
    <ul id="menu-header-menu" class="site-menu nav navbar-nav navbar-right">

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

    </ul>
  </div>
</div>
