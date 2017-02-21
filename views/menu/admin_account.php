<li class="dropdown">
  <a title="My Account Menu" data-link href="<?= /** @noinspection PhpUndefinedMethodInspection */
    _A_::$app->router()->UrlTo('admin'); ?>" class="dropdown-toggle" data-toggle="dropdown" rel="nofollow">
      <i class="fa fa-2x fa-user-circle visible-xs" aria-hidden="true"></i>
      <span class="topnav-label hidden-xs">My Account<span class="caret"></span></span>
    </a>
    <ul class="dropdown-menu topnav-account-dropdown">
      <li><a data-waitloader data-link href="<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('admin/change'); ?>" rel="nofollow">Change Password</a></li>
      <li><a data-waitloader data-link id="log_out" href="<?= /** @noinspection PhpUndefinedMethodInspection */
          _A_::$app->router()->UrlTo('admin/log_out'); ?>" rel="nofollow">Log Out</a></li>
    </ul>
</li>
