<div class="container inner-offset-top half-outer-offset-bottom">
  <div id="content" class="main-content-inner" role="main">
    <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
      <i class="fa fa-angle-left" aria-hidden="true"></i>
      Back
    </a>
    <div style="padding-top: 20px; margin: auto; width: 70%;">
      <div id="message">
        <p>
          <?= isset($message) ? $message : ''; ?>
        <p>
      </div>
    </div>
  </div>
</div>
