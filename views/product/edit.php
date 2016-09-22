<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<script type="text/javascript" src="<?= _A_::$app->router()->UrlTo('upload/js/ajaxupload.3.5.js'); ?>"></script>
<link rel='stylesheet' id='just-style-css' href='<?= _A_::$app->router()->UrlTo('views/css/style.css'); ?>'
      type='text/css' media='all'/>
<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('upload/styles.css'); ?>">
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.css'); ?>">
<script src="<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>"></script>

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">

                <a href="<?= $back_url; ?>" class="back_button"><input type="submit" value="Back" class="button"></a>

                <h1 class="page-title">MODIFY FABRIC</h1>

                <div id="customer_details" class="col2-set">
                    <div class="woocommerce">
                        <div id="form_product">
                            <?= $edit_form; ?>
                        </div>
                    </div>
                </div>
                <b id="tests"></b>
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
                <a id="confirm_action">
                    <input type="button" value="Yes confirm" class="button"/></a>
                <a id="confirm_no">
                    <input type="button" value="No" class="button"/></a>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?= _A_::$app->router()->UrlTo('image/save_link');?>">
    <script src='<?= _A_::$app->router()->UrlTo('views/js/product/edit.js'); ?>' type="text/javascript"></script>