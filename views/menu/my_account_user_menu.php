<li class="dropdown">
    <a href="<?php echo _A_::$app->router()->UrlTo('authorization'); ?>" <?php echo (isset($toggle) && $toggle) ? 'class="dropdown-toggle" data-toggle="dropdown"' : '' ?>>
        <i class="drip-icon-user"></i>
        <span class="topnav-label hidden-xs">
            My Account
        </span>
    </a>
    <?php if (isset($toggle) && $toggle) { ?>
        <ul class="dropdown-menu topnav-account-dropdown">
            <li> <a id="log_out" href="<?php echo _A_::$app->router()->UrlTo('orders/customer_history'); ?>/" rel="nofollow">Orders History</a> <hr></li>
            <li><a href="<?php echo _A_::$app->router()->UrlTo('user/change'); ?>/" rel="nofollow">Change Data</a></li>
            <li><a id="log_out" href="<?php echo _A_::$app->router()->UrlTo('user/log_out'); ?>" rel="nofollow">Log Out</a></li>
        </ul>
    <?php } ?>
</li>
<?php if (!empty($user_name{0})) { ?>
    <li class="user_name">
        <span class="topnav-label hidden-xs">
           <?php echo $user_name; ?>
        </span>
    </li>
<?php } ?>
