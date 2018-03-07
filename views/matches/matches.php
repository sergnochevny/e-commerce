<?php

use app\core\App;

?>

<link rel='stylesheet' charset="UTF-8" href='<?php echo App::$app->router()->UrlTo('css/simple-line-icons.min.css');
?>'
      type='text/css' media='all'/>
<link rel='stylesheet' charset="UTF-8" href='<?php echo App::$app->router()->UrlTo('css/matches.min.css'); ?>'
      type='text/css' media='all'/>
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
