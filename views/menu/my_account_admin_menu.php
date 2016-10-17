<li class="dropdown">

    <a data-link href="<?= _A_::$app->router()->UrlTo('admin');?>" class="dropdown-toggle" data-toggle="dropdown" rel="nofollow">
        <i class="drip-icon-user"></i>
        <span class="topnav-label hidden-xs">My Account</span>
    </a>
    <ul class="dropdown-menu topnav-account-dropdown">
        <li><a data-link href="<?= _A_::$app->router()->UrlTo('admin/change');?>" rel="nofollow">Change Password</a></li>
        <li><a data-link id="log_out" href="<?= _A_::$app->router()->UrlTo('admin/log_out');?>" rel="nofollow">Log Out</a></li>
    </ul>
</li>
