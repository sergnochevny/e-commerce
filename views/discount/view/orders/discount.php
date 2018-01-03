<?php

use app\core\App;

?>
<div id="content" class="col-xs-12 main-content-inner" role="main">
  <?= $list; ?>
</div>
<script src='<?= App::$app->router()->UrlTo('js/simple/edit.min.js'); ?>' type="text/javascript"></script>