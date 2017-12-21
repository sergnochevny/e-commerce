<?php

use app\core\App;

?>
<!--Slider-->
<div id="slider" class="just-slider-wrap">
  <div class="just-slides just-slider-active owl-carousel owl-theme owl-loaded">
    <div class="just-slide"
         style="background-image:url(<?= App::$app->router()->UrlTo('images/slider/slide2.jpg'); ?>);"
         onclick="return location.href = '<?= App::$app->router()->UrlTo('shop'); ?>'">
      <div class="col-xs-12">
        <div class="just-slide-inner">
          <div class="just-slide-detail"
               onclick="return location.href = '<?= App::$app->router()->UrlTo('shop'); ?>'">
            <p class="just-slide-desc">Featured Fabric Selection</p>
            <h2 class="just-slide-title">View our Fabrics</h2>
            <a data-waitloader class="button" href="<?= App::$app->router()->UrlTo('shop'); ?>">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
