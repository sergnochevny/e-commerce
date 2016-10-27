<div class="site-container">
    <?php
    include "views/header.php";
    $opt['pid'] = $data['product_id'];
    ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <p class="woocommerce-result-count">
                    Showing results: <?= $data['results_serch']; ?>
                </p>
                <div class="products">
                    <div class="products">
                        <?php $x = 0; while ($x < $data['results_serch']) { $x++; ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 product-item">
                                <div class="product-inner">
                                    <a href="<?= _A_::$app->router()->UrlTo('product_page', $opt); ?>">
                                        <figure class="product-image-box">
                                            <a href="<?= _A_::$app->router()->UrlTo('product_page', $opt); ?>">
                                                <img width="#" height="266" src="<?= $data['filename']; ?>"
                                                     class="attachment-shop_catalog size-shop_catalog wp-post-image"
                                                     alt=""/>
                                            </a>
                                        </figure>

                                        <span class="on-sale">Sale!</span>
                                        <span
                                            class="product-category"><?= $data['product_category']; ?></span>
                                        <h3><?= $data['product_description']; ?></h3>
                                        <div class="product-price-box clearfix">
                                            <ins><span class="amount"><?= $data['product_amount']; ?>/ yard</span></ins>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


