<link rel='stylesheet' charset="UTF-8"
      href='<?php echo _A_::$app->router()->UrlTo('views/css/simple-line-icons.css'); ?>' type='text/css' media='all'/>
<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/matches.css'); ?>'
      type='text/css' media='all'/>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <div class="entry-content box">
    <div class="row">
      <div class="col-xs-12">
        <?= $list; ?>
      </div>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/matches/matches.js'); ?>' type="text/javascript"></script>
