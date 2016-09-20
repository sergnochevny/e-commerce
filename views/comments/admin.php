<body class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link type='text/css' href='<?= _A_::$app->router()->UrlTo('modal_windows/modal_windows/css/confirm.css'); ?>' rel='stylesheet' media='screen'/>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('modal_windows/modal_windows/js/jquery.simplemodal.js'); ?>'></script>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('modal_windows/modal_windows/js/modal_windows.js'); ?>'></script>

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="text-center"><h1>COMMENTS</h1></div>
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <?php include('views/comments/admin_comments_list.php') ?>
            </div>
        </div>
        <div id="confirm_dialog" class="overlay"></div>
        <div class="popup">
            <div class="fcheck"></div>
            <a class="close" title="close"></a>

            <div class="b_cap_cod_main">
                <p style="color: black;" id="dialog-text"></p>
                <br/>
                <div class="text-center">
                    <a id="confirm_action">
                        <input type="button" value="Yes confirm" class="button"/></a>
                    <a id="confirm_no">
                        <input type="button" value="No" class="button"/></a>
                </div>
            </div>
        </div>

        <div id="comment-view-dialog" class="overlay"></div>
        <div class="popup-view popup">
            <div class="fcheck"></div>
            <a class="close" title="close"></a>

            <div class="" id="comment-view-dialog-data">
                <p style="color: black;" id="dialog-text"></p>
            </div>
        </div>
        <input type="hidden" id="href_update_comment" value="<?= _A_::$app->router()->UrlTo('update_comment_list') ?>">
        <script src='<?= _A_::$app->router()->UrlTo('views/js/comments/admin.js'); ?>' type="text/javascript"></script>