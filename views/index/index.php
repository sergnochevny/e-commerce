<?php include('views/index/main_gallery.php'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <h3 class="section-title">Special For You <br>
            <small>Best item collections in we have in store</small>
          </h3>
          <div class="row">
            <div class="col-md-12">
              <div class="products special-products owl-carousel"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="banner-area">
  <div class="container">
    <div class="col-xs-12">
      <div class="row">
        <div class="row textile-row">
          <div class="col-md-12">
            <div class="col-md-12 background-textile">
              <div class="textile">
                <a class="banner-action-link" href="<?= _A_::$app->router()->UrlTo('shop/last'); ?>">
                  <div class="banner-detail">
                    <p>Brand new life, Brand new textile</p>
                    <h3 class="no-inner-offset-top">What's New</h3>
                    <p>Shop</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="col-md-12 background-textile">
              <div class="best-textile">
                <a class="banner-action-link" href="<?= _A_::$app->router()->UrlTo('shop/best'); ?>">
                  <div class="banner-detail">
                    <p>New Collection</p>
                    <h3 class="no-inner-offset-top">Best textile</h3>
                    <p>Shop</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="col-md-12 background-textile">
              <div class="popular-textile">
                <a class="banner-action-link" href="<?= _A_::$app->router()->UrlTo('shop/popular'); ?>">
                  <div class="banner-detail">
                    <p>New collection</p>
                    <h3 class="no-inner-offset-top">Popular textile</h3>
                    <p>Shop</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row bestseller-row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <h3 class="section-title">Best Sellers <br>
            <small>Best item collection we have in store</small>
          </h3>
          <div class="row products best-products"></div>
          <div class="row bestseller-action-row">
            <div class="col-md-12 text-center">
              <a href="<?= _A_::$app->router()->UrlTo('shop/bestsellers'); ?>" class="button button-2x">MORE</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<input type="hidden" id="get_url" value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'carousel']); ?>">
<input type="hidden" id="slider_url"
       value="<?= _A_::$app->router()->UrlTo('shop/widget', ['type' => 'bsells_horiz']); ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/index/index.js'); ?>' type="text/javascript"></script>
<?php include('views/index/block_footer.php'); ?>

