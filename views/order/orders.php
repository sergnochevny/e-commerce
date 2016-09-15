<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?php echo $back_url; ?>" class="back_button"><input type="button" value="Back" class="button"></a>
                <?php echo $orders; ?>
                <br/>
            </div>
            <nav role="navigation" class="paging-navigation">
                <h4 class="sr-only">Orders navigation</h4>
                <ul class='pagination'>
                    <?php echo isset($paginator) ? $paginator : ''; ?>
                </ul>
            </nav>
        </div>
    </div>
 