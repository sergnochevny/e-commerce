<li class="dropdown my-account">
  <a <?= (isset($user_logged) && $user_logged) ? '' : 'data-waitloader' ?>
    data-link
    href="<?= _A_::$app->router()->UrlTo('authorization'); ?>" <?= (isset($user_logged) && $user_logged) ? 'class="dropdown-toggle" data-toggle="dropdown"' : '' ?>>
    <i class="fa fa-2x fa-user-circle visible-xs" aria-hidden="true"></i>
    <span class="topnav-label hidden-xs"><?= $user_logged ? 'My Account' : 'Login'; ?></span>
  </a>

  <?php if(isset($user_logged) && $user_logged) { ?>
    <ul class="dropdown-menu topnav-account-dropdown">
      <li>
        <a data-waitloader data-link title="Favorite Fabrics" href="<?= _A_::$app->router()->UrlTo('favorites'); ?>">
          Favorite Fabrics
        </a>
      </li>
      <li>
        <a data-waitloader data-link title="Recommendations for You"
           href="<?= _A_::$app->router()->UrlTo('recommends'); ?>">
          Recommendations for You
        </a>
      </li>
      <li>
        <a data-waitloader data-link title="My Orders" href="<?= _A_::$app->router()->UrlTo('orders'); ?>">
          My Orders
        </a>
        <hr>
      </li>
      <li>
        <a data-waitloader data-link title="View my Basket" href="<?= _A_::$app->router()->UrlTo('cart'); ?>">
          View my Basket
        </a>
        <hr>
      </li>
      <li>
        <a data-waitloader data-link title="My Profile" href="<?= _A_::$app->router()->UrlTo('user/change'); ?>">
          My Profile
        </a>
      </li>
      <li>
        <a data-waitloader data-link title="Log Out" id="log_out"
           href="<?= _A_::$app->router()->UrlTo('user/log_out'); ?>">
          Log Out
        </a>
      </li>
    </ul>
  <?php } ?>
</li>
