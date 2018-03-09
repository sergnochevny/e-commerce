<?php

use app\core\App;

?>
<form action="<?= $action ?>" method="post" data-search style="display: none"></form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/search.min.js'), 4, true);?>