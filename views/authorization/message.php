<div class="container">
  <div id="content" class="main-content-inner" role="main">
    <a href="<?= _A_::$app->router()->UrlTo('/'); ?>" class="button back_button">Back</a>
    <div style="padding-top: 20px; margin: auto; width: 70%;">
      <div id="message">
        <p>
          <?= isset($message) ? $message : ''; ?>
        <p>
      </div>
    </div>
  </div>
</div>
