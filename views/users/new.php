<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?php echo $back_url; ?>" class="back_button"><input type="button" value="Back" class="button"></a>

                <div id="customer_details" style="padding-top: 20px; margin: auto; width: 600px;">
                    <div id="user_form">
                        <?php include('views/users/new_user_form.php')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>