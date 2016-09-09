<div class="col-md-10 col-lg-10">
    <div class="navbar-collapse collapse navbar-collapse-top">
        <ul id="menu-header-menu" class="site-menu nav navbar-nav navbar-right">

            <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item active">
                <a title="" href="<?php echo $base_url?>">Home</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a title="Shop" aria-haspopup="true" class="has-submenu" href="<?php echo $base_url?>/shop">Shop<span class="caret"></span></a>
                <?php
                echo isset($shop_menu)?$shop_menu:'';
                ?>
            </li>
            <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children dropdown">
                <a title="" href="#" class="has-submenu" id="sm-14556147971389604-1" aria-haspopup="true"
                   aria-controls="sm-14556147971389604-2" aria-expanded="false">Shop <span class="caret"></span></a>
                <ul role="menu" class=" dropdown-menu" style="z-index: 101;">
                </ul>
            </li>-->
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a title="Blog"  aria-haspopup="true" class="has-submenu" href="<?php echo $base_url?>/blog">Blog<span class="caret"></span></a>
                <?php
                echo isset($blog_menu)?$blog_menu:'';
                ?>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a title="" href="<?php echo $base_url?>/newsletter">Newsletter</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a title="" href="<?php echo $base_url?>/service">Service</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a title="" href="<?php echo $base_url?>/about">About us</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a title="" href="<?php echo $base_url?>/contact">Contact</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a title="" href="<?php echo $base_url?>/matches">Matches</a>
            </li>

        </ul>
    </div>
</div>
