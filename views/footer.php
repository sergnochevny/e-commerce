<div class="footer-widgets-bottom">
  <div class="container">
    <div class="footer-widgets-bottom-inner">
      <div class="row footer-block">
        <div class="col-sm-8 col-md-6 col-xs-12">
          <div class="col-xs-6">
            <aside id="text-3" class="widget widget_text">
              <h4 class="widget-title">Shipping</h4>
              <div class="textwidget">
                <p>We ship Worldwide. Products are generally shipped within 24 to 72 hours from the time of approved
                  payment received.</p>
              </div>
              <h4 class="widget-title">Privacy Policy</h4>
              <div class="textwidget">
                <p class="copyProducts">Your personal information is never under any circumstances shared with any other
                  individuals or organizations.
                  <a data-waitloader class="copyProducts" href="<?= _A_::$app->router()->UrlTo('privacy'); ?>">privacy
                    policy</a>.
                </p>
              </div>
              <!--<h4 class="widget-title">Security Information</h4>
              <div class="textwidget">
                <p>All purchase transactions made on our site are fully and completely secured.</p>
              </div>-->
            </aside>
          </div>
          <div class="col-xs-6">
            <aside id="text-2" class="widget widget_text">
              <h4 class="widget-title">Contact Information</h4>
              <div class="textwidget">
                <p><b>iluvfabrix</b> (Division of Fabric Love LLC)<br/>
                  211 Teramar Way<br/>
                  El Paso, Texas, 79922<br/>
                  United States</p>
                <p><b>Email:</b> <a
                      href="mailto:<?= _A_::$app->keyStorage()->system_info_email; ?>"><?= _A_::$app->keyStorage()->system_info_email; ?></a><br/>
                  <b>Tel:</b> <a href="tel:9155870200">(915) 587-0200</a></p>
              </div>
            </aside>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-6">
          <div class="col-sm-12 col-xs-6 col-md-6">
            <aside id="nav_menu-2" class="widget widget_nav_menu">
              <h4 class="widget-title">Customer Services</h4>
              <div class="menu-customer-services-container">
                <ul id="menu-customer-services" class="menu">
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('/') ?>">Home</a>
                  </li>
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('about') ?>">About Us</a>
                  </li>
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('newsletter') ?>">Newsletter</a>
                  </li>
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('service') ?>">Service</a>
                  </li>
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('contact') ?>">Contact</a>
                  </li>
                </ul>
              </div>
            </aside>
          </div>
          <div class="col-sm-12 col-xs-6 col-md-6">
            <aside id="nav_menu-3" class="widget widget_nav_menu">
              <h4 class="widget-title">My Account</h4>
              <div class="menu-my-account-container">
                <ul id="menu-my-account" class="menu">
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('authorization') ?>">My Account</a>
                  </li>
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('shop') ?>">Shop</a>
                  </li>
                  <li class="menu-item menu-item-type-custom menu-item-object-custom">
                    <a data-waitloader href="<?= _A_::$app->router()->UrlTo('blog/view') ?>">Blog</a>
                  </li>
                </ul>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>