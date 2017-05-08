<link rel='stylesheet' charset="UTF-8"
      href='<?php /** @noinspection PhpUndefinedMethodInspection */
        echo _A_::$app->router()->UrlTo('views/css/simple-line-icons.css'); ?>' type='text/css' media='all'/>
<link rel='stylesheet' charset="UTF-8" href='<?php /** @noinspection PhpUndefinedMethodInspection */
  echo _A_::$app->router()->UrlTo('views/css/matches.min.css'); ?>'
      type='text/css' media='all'/>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <div class="entry-content">
    <div class="row">
      <div class="col-xs-12">
        <?= $list; ?>
      </div>
    </div>
  </div>
</div>
<?php include('views/index/block_footer.php'); ?>
<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/matches/matches.min.js'); ?>' type="text/javascript"></script>
