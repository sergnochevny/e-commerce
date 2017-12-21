<?php

use app\core\App;

?>

<div class="container inner-offset-top half-outer-offset-bottom">
  <div id="content" class="col-xs-12 main-content-inner box" role="main">
    <div style="padding-top: 20px; margin: auto; width: 600px;">
      <div class="error404" id="message404">
        <p class="title404">
          Sorry, the page not found.
        <p>
        <p class="msg404">
          The link you followed probably broken, <br> or the page has been removed.<br><br>
          Return to <a href="<?= App::$app->router()->UrlTo('/'); ?>">homepage</a>.
        <p>
          <?php if(!empty($message)): ?>
        <p class="msg404">
          <?= $message ?>
        <p>
          <?php endif; ?>
      </div>
    </div>
  </div>
</div>
