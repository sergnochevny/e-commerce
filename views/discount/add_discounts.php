<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<link rel="stylesheet" href="<?php echo _A_::$app->router()->UrlTo('mnf');?>/views/css/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="<?php echo _A_::$app->router()->UrlTo('mnf');?>/views/js/jquery-ui.js"></script>
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="discounts"><input type="submit" value="Back" class="button"></a>

                <div id="customer_details" style="margin: auto; width: 650px;">
                    <h1 class="page-title">ADD DISCOUNT</h1>
                    <small style="color: black; font-size: 10px;">
                        Use this form to add/update discounts to the system. <br/>
                        Clicking on the section title will open a help file explaining that section.
                    </small>
                    <div id="discount_form">
                        <?php include('views/discount/add_discounts_form.php') ?>
                    </div>
                </div>
                <br/>
            </div>
        </div>
    </div>
</div>
<?php include('views/discount/modal_rules.php'); ?>