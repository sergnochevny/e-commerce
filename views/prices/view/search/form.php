<?php

use app\core\App;

?>
<form action="<?= $action ?>" method="post" data-search style="display: none"></form>
<script src="<?= App::$app->router()->UrlTo('js/search.min.js'); ?>"></script>
