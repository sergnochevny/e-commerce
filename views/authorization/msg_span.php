<?php

use app\core\App;

?>
<div style="padding-top: 20px; margin: auto; width: 600px;">
  <div id="message"><p><span><?= isset($message) ? $message : ''; ?></span>
    <p></div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/authorization/msg_span.min.js'), 5); ?>