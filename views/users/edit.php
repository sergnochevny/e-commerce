<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content main-content-shop">
    <div class="container">
      <div id="content" class="main-content-inner" role="main">
        <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        <div style="padding-top: 20px; margin: auto; width: 600px;">
          <h1 class="page-title"><?= $form_title ?></h1>
          <div id="form_content">
            <?= $form; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
