<li class="dropdown my-account">
    <a <?= (isset($toggle) && $toggle) ? '': 'data-waitloader'?> data-link href="<?= _A_::$app->router()->UrlTo('authorization'); ?>" <?= (isset($toggle) && $toggle) ? 'class="dropdown-toggle" data-toggle="dropdown"' : '' ?>>
        <i class="drip-icon-user"></i>
        <span class="topnav-label hidden-xs">
            My Account
        </span>
    </a>
    <?php if (isset($toggle) && $toggle) { ?>
        <ul class="dropdown-menu topnav-account-dropdown">
            <li><a data-waitloader data-link id="log_out" href="<?= _A_::$app->router()->UrlTo('favorites'); ?>" rel="nofollow">Favorites</a></li>
            <li><a data-waitloader data-link id="log_out" href="<?= _A_::$app->router()->UrlTo('orders'); ?>" rel="nofollow">Orders</a><hr></li>
            <li><a data-waitloader data-link href="<?= _A_::$app->router()->UrlTo('user/change'); ?>" rel="nofollow">Change Data</a></li>
            <li><a data-waitloader data-link id="log_out" href="<?= _A_::$app->router()->UrlTo('user/log_out'); ?>" rel="nofollow">Log Out</a></li>
        </ul>
    <?php } ?>
</li>
<?php if (!empty($user_name{0})) { ?>
    <li class="user_name">
        <span class="topnav-label hidden-xs">
           <?= $user_name; ?>
        </span>
    </li>
<?php } ?>
