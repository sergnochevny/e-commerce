<?php

use app\core\App;

?>
<div id="content" class="col-xs-12 main-content-inner" role="main">
  <?= $list; ?>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/simple/edit.min.js'), 4); ?>