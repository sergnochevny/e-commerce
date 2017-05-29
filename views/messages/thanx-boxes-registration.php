<?php if(isset($warning) || isset($error)) : ?>
  <div class="col-xs-12 alert-container">
    <div class="row">
      <?php if(isset($warning)) : ?>
        <div class="col-xs-12 alert-success danger">
          <button id="close-container" type="button" class="close-container"
                  data-waitloader
                  data-destroy="alert-container"
                  data-redirect="<?= _A_::$app->router()->UrlTo('authorization'); ?>"
                  aria-hidden="true">×
          </button>
          <?php foreach($warning as $msg): ?>
            <?php if(!empty($msg)): ?>
              <?= $msg; ?>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if(isset($error)) : ?>
        <div class="col-xs-12 alert-danger danger">
          <button id="close-container" type="button" class="close-container"
                  data-destroy="alert-container"
                  aria-hidden="true">×
          </button>
          <?php foreach($error as $msg) : ?>
            <?php if(!empty($msg)): ?>
              <pre><?= $msg; ?></pre>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
