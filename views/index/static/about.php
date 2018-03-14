<?php

use app\core\App;

?>
<?php //$this->registerCSSFile(App::$app->router()->UrlTo('css/static_common.min.css')); ?>

<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 static box">
    <?php $back_url = App::$app->router()->UrlTo('shop'); ?>

    <div class="col-xs-12 col-sm-2 back_button_container">
      <div class="row">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          To Shop
        </a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-8 text-center">
      <h1 class="page-title">About Us</h1>
      <h2 class="page-title">
        <small>25 Years Selling Designer Fabrics</small>
      </h2>
    </div>

    <div class="col-xs-12">
      <div class="row">
        <p class="text-justify">
          We travel the world to source out and bring you the finest, most exclusive and exquisite
          fabrics available, many of which are commonly available only to the top design trade, and we
          sell them below trade wholesale.
        </p>

        <p class="text-justify">
          Over the years iLuvFabix.com and our designer with over 25 years in the high end Design
          Marketplace, has acquired a client base second to none.
        </p>

        <p class="text-justify">
          As a special service to our purchasing customers, iluvfabrix.com is proud to provide
          Professional Design Services AT NO COST. Our designer, upon request will group fabrics
          together FOR YOUR HOME and email you the pictures. In this way you not only get access to
          the &laquo;Best of the Best&raquo; fabrics Below Trade Wholesale, you get the services of a Professional
          Designer without Paying the Hourly Fee.
        </p>
      </div>
    </div>

  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/static/static.min.js'), 4); ?>