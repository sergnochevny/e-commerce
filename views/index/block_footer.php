<div class="footer-widgets-top">
  <div class="container">
    <div class="col-xs-12 inner-offset-top">
      <div class="row footer-widgets-top-inner">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="row">
            <h4 class="section-title">Best Sellers Products</h4>
            <aside id="woocommerce_products-5" class="widget woocommerce widget_products">
              <div id="bsells_products" class="products product_list_widget">
              </div>
            </aside>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="row footer-widget-row">
            <h4 class="section-title">Popular Textile</h4>
            <aside id="woocommerce_products-2" class="widget woocommerce widget_products">
              <div id="popular_products" class="products product_list_widget">
              </div>
            </aside>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="row">
            <h4 class="section-title">New Products</h4>
            <aside id="woocommerce_products-3" class="widget woocommerce widget_products">
              <div id="new_products" class="products product_list_widget">
              </div>
            </aside>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="row footer-widget-row">
            <h4 class="section-title">Featured Products</h4>
            <aside id="woocommerce_products-4" class="widget woocommerce widget_products">
              <div id="best_products" class="products product_list_widget">
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="hidden_bsells_products"
       value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'bestsellers']) ?>">
<input type="hidden" id="hidden_popular_products"
       value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'popular']) ?>">
<input type="hidden" id="hidden_new_products"
       value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'new']) ?>">
<input type="hidden" id="hidden_best_products"
       value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'best']) ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/index/block_footer.js'); ?>' type="text/javascript"></script>