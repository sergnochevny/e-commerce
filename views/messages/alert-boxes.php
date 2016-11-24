<?php if(isset($warning) || isset($error)) : ?>
  <div class="col-xs-12 alert-container">
    <div class="row">
      <?php if(isset($warning)) : ?>
        <div class="col-xs-12 alert-success danger">
          <?php foreach($warning as $msg): ?>
            <?php if(!empty($msg)): ?>
              <p><?= $msg; ?></p>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if(isset($error)) : ?>
        <div class="col-xs-12 alert-danger danger">
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
