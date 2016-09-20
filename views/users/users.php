<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link charset="UTF-8" type='text/css' href='<?= _A_::$app->router()->UrlTo('modal_windows/modal_windows/css/confirm.css'); ?>' rel='stylesheet' media='screen'/>
<script charset="UTF-8" type='text/javascript' src='<?= _A_::$app->router()->UrlTo('modal_windows/modal_windows/js/jquery.simplemodal.js'); ?>'></script>
<script charset="UTF-8" type='text/javascript' src='<?= _A_::$app->router()->UrlTo('modal_windows/modal_windows/js/modal_windows.js'); ?>'></script>

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <?php include('views/users/list.php') ?>
            </div>
        </div>
        <div id="confirm_dialog" class="overlay"></div>
        <div class="popup">
            <div class="fcheck"></div> <a class="close" title="close"></a>

            <div class="b_cap_cod_main">
                <p style="color: black;">You confirm the removal ?</p>
                <br/>
                <div class="text-center">
                    <a id="confirm_action"><input type="button" value="Yes confirm" class="button"/></a>
                    <a id="confirm_no"><input type="button" value="No" class="button"/></a></div>
            </div>
        </div>
        <script src='<?= _A_::$app->router()->UrlTo('views/js/users/users.js'); ?>' type="text/javascript"></script>