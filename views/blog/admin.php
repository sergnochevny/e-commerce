<body class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<link type='text/css' href='<?= _A_::$app->router()->UrlTo('modal_windows/modal_windows/css/confirm.css'); ?>' rel='stylesheet' media='screen'/>

<div class="site-container">
    <?php include "views/header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <?php include('views/blog/admin_content.php')?>
            </div>
        </div>
    </div>


</div>

<div id="confirm_dialog" class="overlay"></div>
<div class="popup">
    <div class="fcheck"></div>
    <a class="close" title="close"></a>

    <div class="b_cap_cod_main">
        <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
        <br/>
        <div class="text-center">
            <a id="confirm_action"><input type="button" value="Yes confirm" class="button"/></a>
            <a id="confirm_no"><input type="button" value="No" class="button"/></a>
        </div>
    </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/admin.js'); ?>' type="text/javascript"></script>