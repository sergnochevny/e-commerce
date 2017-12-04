<div class="footer-widgets-top outer-offset-top">
  <div class="container inner-offset-top half-outer-offset-bottom">
    <div class="col-xs-12 box inner-offset-top">
      <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="row">
          <h4 class="section-title">Best Sellers Products</h4>
          <aside id="woocommerce_products-5" class="widget woocommerce widget_products">
            <div id="bsells_products" class="products product_list_widget">
              <div data-load="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'bestsellers']) ?>"></div>
            </div>
          </aside>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="row footer-widget-row">
          <h4 class="section-title">Popular Textiles</h4>
          <aside id="woocommerce_products-2" class="widget woocommerce widget_products">
            <div id="popular_products" class="products product_list_widget">
              <div data-load="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'popular']) ?>"></div>
            </div>
          </aside>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="row footer-widget-row-lg">
          <h4 class="section-title">New Products</h4>
          <aside id="woocommerce_products-3" class="widget woocommerce widget_products">
            <div id="new_products" class="products product_list_widget">
              <div data-load="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'new']) ?>"></div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </div>
</div>