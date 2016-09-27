<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.css');?>">
<script src="<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js');?>"></script>
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?=_A_::$app->router()->UrlTo('discount')?>"><input type="submit" value="Back" class="button"></a>

                <div id="customer_details">
                    <h1 class="page-title"> MODIFY DISCOUNT</h1>
                    <p class="text-center">
                        <small style="color: black; font-size: 13px;">
                            Use this form to add/update discounts to the system.
                        </small>
                    </p>
                    <hr>
                    <p class="text-center">
                        <small style="color: black; font-size: 11px; color: #999">
                            Clicking on the section title will open a help file explaining that section.
                        </small>
                    </p>
                    <div id="discount_form">
                        <?= $form; ?>
                    </div>
                </div>
                <br/>
            </div>
        </div>
    </div>
</div>
<?php include('views/discount/modal_rules.php'); ?>