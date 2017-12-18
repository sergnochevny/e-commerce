<?php if(!Controller_User::is_logged()) : ?>
  <li class="dropdown">
    <a class="dropdown-toggle" data-waitloader data-link title="Newsletter"
       href="<?= _A_::$app->router()->UrlTo('newsletter') ?>">
      <i class="fa fa-newspaper-o fa-2x visible-xs"></i>
      <span class="topnav-label hidden-xs">Newsletter</span>
    </a>
  </li>
<?php endif; ?>
<li class="dropdown">
  <a class="dropdown-toggle" data-waitloader data-link title="Service"
     href="<?= _A_::$app->router()->UrlTo('service') ?>">
    <i class="fa fa-cog fa-2x visible-xs"></i>
    <span class="topnav-label hidden-xs">Service</span>
  </a>
</li>

<li class="dropdown">
  <a title="About" class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
    <i class="fa fa-info-circle fa-2x visible-xs" aria-hidden="true"></i>
    <span class="topnav-label hidden-xs">About<span class="caret"></span></span>
  </a>
  <ul class="dropdown-menu topnav-about-dropdown">
    <li class="menu-item menu-item-type-post_type menu-item-object-page">
      <a data-waitloader data-link title="About us" href="<?= _A_::$app->router()->UrlTo('about') ?>">
        About Us
      </a>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-page">
      <a data-waitloader data-link title="Contact Us" href="<?= _A_::$app->router()->UrlTo('contact') ?>">
        Contact Us
      </a>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-page">
      <a data-waitloader data-link title="Blog" href="<?= _A_::$app->router()->UrlTo('blog/view') ?>">
        Blog
      </a>
    </li>
  </ul>
</li>

<li class="dropdown my-account">
  <a data-link
     href="javascript:void(0);"
     class="dropdown-toggle"
     data-toggle="dropdown">
    <i class="fa fa-user-circle fa-2x visible-xs"></i>
    <span class="topnav-label hidden-xs"><?= $user_logged ? 'My Account' : 'Login'; ?><span class="caret"></span></span>
  </a>
  <?php if(isset($user_logged) && $user_logged): ?>
    <ul class="dropdown-menu topnav-account-dropdown">
      <li>
        <a data-waitloader data-link title="My Orders" href="<?= _A_::$app->router()->UrlTo('orders'); ?>">
          My Orders
        </a>
        <hr>
      </li>
      <li>
        <a data-waitloader data-link title="View My Cart" href="<?= _A_::$app->router()->UrlTo('cart'); ?>">
          View My Cart
        </a>
        <hr>
      </li>
      <li>
        <a data-waitloader data-link title="My Profile" href="<?= _A_::$app->router()->UrlTo('user/change'); ?>">
          My Profile
        </a>
      </li>
      <?php if(isset($user_logged) && $user_logged): ?>
        <li>
          <a data-waitloader data-link title="Log Out" id="log_out"
             href="<?= _A_::$app->router()->UrlTo('user/log_out'); ?>">
            Log Out
          </a>
        </li>
      <?php endif; ?>
    </ul>
  <?php else: ?>
    <div class="dropdown-menu topnav-login-dropdown">
      <div class="col-xs-12" data-role="form_content">
        <div data-load="<?= _A_::$app->router()->UrlTo('authorization', ['method' => 'short']) ?>">
          <script type='text/javascript'
                  src='<?= _A_::$app->router()->UrlTo('js/authorization/load.js'); ?>'></script>
        </div>
      </div>
    </div>
  <?php endif; ?>
</li>
