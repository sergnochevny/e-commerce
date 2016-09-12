<li class="dropdown">

    <a href="<?php echo _A_::$app->router()->UrlTo('mnf');?>/admin" class="dropdown-toggle" data-toggle="dropdown" rel="nofollow">
        <i class="drip-icon-user"></i>
        <span class="topnav-label hidden-xs">My Account</span>
    </a>
    <!--<ul class="dropdown-menu topnav-account-dropdown">
        <li><a href="#" rel="nofollow">Sign In</a></li>
    </ul>-->
    <ul class="dropdown-menu topnav-account-dropdown">
        <li><a href="#" rel="nofollow">Change Password</a></li>
        <li><a id="log_out" href="<?php echo _A_::$app->router()->UrlTo('mnf');?>/admin_log_out" rel="nofollow">Log Out</a></li>
    </ul>
</li>
