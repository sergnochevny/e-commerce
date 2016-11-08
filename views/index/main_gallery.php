<!--Slider-->
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/owl.carousel.css'); ?>">
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/owlcarousel/owl.theme.default.min.css'); ?>">
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/owlcarousel/owl.carousel.min.js'); ?>'></script>

<div class="just-slider-wrap big-gallery">
  <div class="just-slides just-slider-active owl-carousel owl-theme owl-loaded">
    <div class="just-slide"
         style="background-image:url(<?= _A_::$app->router()->UrlTo('views/images/slider/slide1.jpg'); ?>);background-size:cover;background-position:center right;background-repeat:no-repeat;">
      <div class="col-xs-12">
        <div class="just-slide-inner">
          <div class="just-slide-detail"
               onclick="return location.href = '<?= _A_::$app->router()->UrlTo('shop'); ?>'">
            <p class="just-slide-desc">Featured Fabric Selection</p>
            <h2 class="just-slide-title">View our Fabrics</h2>
            <a data-waitloader class="button" href="<?= _A_::$app->router()->UrlTo('shop'); ?>">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
    <div class="just-slide"
         style="background-image:url(<?= _A_::$app->router()->UrlTo('views/images/slider/slide2.jpg'); ?>);background-size:cover;background-position:center right;background-repeat:no-repeat;">
      <div class="col-xs-12">
        <div class="just-slide-inner">
          <div class="just-slide-detail"
               onclick="return location.href = '<?= _A_::$app->router()->UrlTo('shop'); ?>'">
            <p class="just-slide-desc">Featured Fabric Selection</p>
            <h2 class="just-slide-title">View our Fabrics</h2>
            <a data-waitloader class="button" href="<?= _A_::$app->router()->UrlTo('shop'); ?>">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/index/main_gallery.js'); ?>' type="text/javascript"></script>