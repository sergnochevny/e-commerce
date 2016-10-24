<div class="footer-widgets-top">
    <div class="container">
        <div class="footer-widgets-top-inner">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-5" class="widget woocommerce widget_products">
                        <h4 class="widget-title">Best Sellers Products</h4>
                        <ul id="bsells_products" class="product_list_widget text-justify">
                        </ul>
                    </aside>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-2" class="widget woocommerce widget_products">
                        <h4 class="widget-title">Popular Textile</h4>
                        <ul id="popular_products" class="product_list_widget text-justify">
                        </ul>
                    </aside>
                </div>
                <div class="clear"></div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-3" class="widget woocommerce widget_products">
                        <h4 class="widget-title">New Products</h4>
                        <ul id="new_products" class="product_list_widget text-justify">
                        </ul>
                    </aside>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-4" class="widget woocommerce widget_products">
                        <h4 class="widget-title">Featured Products</h4>
                        <ul id="best_products" class="product_list_widget text-justify">
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="hidden_bsells_products" value="<?= _A_::$app->router()->UrlTo('shop/widget_bsells')?>">
<input type="hidden" id="hidden_popular_products" value="<?= _A_::$app->router()->UrlTo('shop/widget_popular')?>">
<input type="hidden" id="hidden_new_products" value="<?= _A_::$app->router()->UrlTo('shop/widget_new')?>/">
<input type="hidden" id="hidden_best_products" value="<?= _A_::$app->router()->UrlTo('shop/widget_best')?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/index/block_footer.js'); ?>' type="text/javascript"></script>