<div class="container">
  <div id="content" class="main-content-inner" role="main">
    <a href="<?= _A_::$app->router()->UrlTo('/'); ?>" class="back_button button">Back</a>
    <div style="padding-top: 20px; margin: auto; width: 600px;">
      <div id="message">
        <p><span><?= isset($message) ? $message : ''; ?></span>
        <p>
      </div>
    </div>
  </div>
</div>
