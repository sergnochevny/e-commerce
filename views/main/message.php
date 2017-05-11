<div class="container inner-offset-top half-outer-offset-bottom">
  <div id="content" class="col-xs-12 main-content-inner box" role="main">
    <a href="<?= _A_::$app->router()->UrlTo('/'); ?>" class="back_button button">Back</a>
    <div style="padding-top: 20px; margin: auto; width: 600px;">
      <div id="message">
        <p><span><?= isset($message) ? $message : ''; ?></span>
        <p>
      </div>
    </div>
  </div>
</div>
