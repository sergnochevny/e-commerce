<?php

use app\core\App;

?>
<?php //$this->registerCSSFile(App::$app->router()->UrlTo('css/blog_common.min.css')); ?>
<?php $this->registerCSSFile(App::$app->router()->UrlTo('css/blog.min.css'), 1); ?>

<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
  <div class="container inner-offset-top half-outer-offset-bottom">
    <div id="blog" class="col-xs-12 main-content-inner box" role="main">
      <div class="page type-page status-publish entry">
        <?php $back_url = App::$app->router()->UrlTo('shop'); ?>

        <div class="row">
          <div class="col-xs-12 col-sm-2 back_button_container">
            <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
              To Shop
            </a>
          </div>
          <div class="col-xs-12 col-sm-8 text-center">
            <h1 class="page-title">Blog</h1>
          </div>
        </div>
      </div>

      <div id="content" class="entry-content">
        <?= $list ?>
      </div>
    </div>
  </div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/blog/view.min.js'), 4, true); ?>