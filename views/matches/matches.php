<?php

use app\core\App;

?>

<?php //$this->registerCSSFile(App::$app->router()->UrlTo('css/matches_common.min.css'), 0); ?>
<?php $this->registerCSSFile(App::$app->router()->UrlTo('css/matches.min.css'), 1); ?>

<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <div class="entry-content box">
    <div class="row">
      <div class="col-xs-12">
        <?= $list; ?>
      </div>
    </div>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/matches/matches.min.js'), 4);?>
