<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <p class="woocommerce-result-count">
                    Showing results: <?= $data['results_serch']; ?>
                </p>
                <ul class="products">
                    <div class="product-inner">
                        <?php
                        $x = 0;
                        while ($x < $data['results_serch']) {
                            $x++; ?>

                            <li class="last product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">
                                <div class="product-inner">
                                    <figure class="product-image-box">
                                        <a href="product_page?p_id=<?= $data['product_id']; ?>">
                                            <img width="#" height="266" src="<?= $data['filename']; ?>"
                                                 class="attachment-shop_catalog size-shop_catalog wp-post-image"
                                                 alt=""/></a>
                                    </figure>
                                    <a href="product_page?p_id=<?= $data['product_id']; ?>">
                                        <span class="onsale">Sale!</span>
                                        <span
                                            class="product-category"><?= $data['product_category']; ?></span>

                                        <h3><?= $data['product_description']; ?></h3>

                                        <div class="product-price-box clearfix">
                                            <ins><span class="amount"><?= $data['product_amount']; ?>
                                                    /yard</span></ins>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </li>

                        <?php } ?>
                </ul>
            </div>
        </div>
    </div>


</div>


