<?php

use app\core\App;

?>
<?php //$this->registerCSSFile(App::$app->router()->UrlTo('css/static_common.min.css')); ?>

<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
  <div id="content" class="container inner-offset-top half-outer-offset-bottom">
    <div class="col-xs-12 box">

      <div class="row">
        <?php if(empty($back_url)) {
          $to_shop = true;
          $back_url = App::$app->router()->UrlTo('shop');
        } ?>
        <div class="col-xs-12 col-sm-2 back_button_container">
          <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <?= !empty($to_shop) ? 'To Shop' : 'Back' ?>
          </a>
        </div>
        <div class="col-xs-12 <?= empty($back_url) ? '' : 'col-sm-8' ?> text-center">
          <h1 class="page-title">Fabric and Upholstery Estimator</h1>
          <h2 class="page-title">
            <small>Please use the table below to help to estimate the amount of fabric you will need.</small>
          </h2>
        </div>
      </div>

      <div class="estimate">
        <div class="estimate__cont">
          <div class="row">
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>3 SEAT SOFA</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/01.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>6' 13 yds</li>
                    <li>7' 15 yds</li>
                    <li>9' 20 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>LOVESEAT</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/02.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>13 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>LOVESEAT</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/03.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>11 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>CHAIR</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/04.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>7 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>CHAIR</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/05.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>6 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>CHAIR</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/06.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>4 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>CHAIR</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/07.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>6 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>CHAIR</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/08.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>4.5 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>CHAIR</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/09.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>1.5 yds</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="cont-item-wrap">
                <div class="head-cont">
                  <h4>OTTOMAN</h4>
                  <img src="<?= App::$app->router()->UrlTo('images/furniture/10.png'); ?>" alt="img">
                </div>
                <div class="desc-cont">
                  <h5>Estimated Yards:</h5>
                  <ul>
                    <li>2.5 yds</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/static/static.min.js'), 4); ?>