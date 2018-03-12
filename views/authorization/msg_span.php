<?php

use app\core\App;

?>
<div class="lost_password_container text-center">
  <div id="message">
    <p><span><?= isset($message) ? $message : ''; ?></span><p>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/msg_span.min.js'), 5); ?>