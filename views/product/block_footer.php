<div class="footer-widgets-top">
    <div class="container">
        <div class="footer-widgets-top-inner">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-5" class="widget woocommerce widget_products">
                        <h4 class="widget-title">Best Selling Products</h4>
                        <ul id="bsells_products" class="product_list_widget">
                        </ul>
                    </aside>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-2" class="widget woocommerce widget_products">
                        <h4 class="widget-title">Popular Textile</h4>
                        <ul id="popular_products" class="product_list_widget">
                        </ul>
                    </aside>
                </div>
                <div class="clear"></div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-3" class="widget woocommerce widget_products">
                        <h4 class="widget-title">New Products</h4>
                        <ul id="new_products" class="product_list_widget">
                        </ul>
                    </aside>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <aside id="woocommerce_products-4" class="widget woocommerce widget_products">
                        <h4 class="widget-title">Featured Products</h4>
                        <ul id="best_products" class="product_list_widget">
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function (event) {
            $('#bsells_products').load('<?php echo _A_::$app->router()->UrlTo('shop/widget_bsells')?>');
            $('#popular_products').load('<?php echo _A_::$app->router()->UrlTo('shop/widget_popular')?>');
            $('#new_products').load('<?php echo _A_::$app->router()->UrlTo('shop/widget_new')?>/');
            $('#best_products').load('<?php echo _A_::$app->router()->UrlTo('shop/widget_best')?>');
            }
        );
    })(jQuery);
</script>