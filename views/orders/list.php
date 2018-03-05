<?php

use app\core\App;
use controllers\ControllerAdmin;

$user_id = App::$app->get('aid');
$is_admin = ControllerAdmin::is_logged();
include(APP_PATH . '/views/messages/alert-boxes.php');

?>

<?php if(isset($back_url)): ?>
  <div class="col-xs-12">
    <div class="row">
      <div class="col-xs-12 col-sm-2 back_button_container">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          Back
        </a>
      </div>
      <div class="col-xs-12 col-sm-8 text-center">
        <div class="row">
          <h3
            class="page-title"><?= (isset($user_id) && !$is_admin) ? $data[0]['username'] : ((!$is_admin) ? 'My' : '') ?>
            Orders</h3>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="col-xs-12 text-center">
    <h1 class="page-title"><?= (isset($user_id) && !$is_admin) ? $data[0]['username'] : ((!$is_admin) ? 'My' : '') ?>
      Orders</h1>
  </div>
<?php endif; ?>
<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header text-right">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
    <?= isset($show_by) ? $show_by : ''; ?>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <?= $list; ?>
  </div>
</div>

<?php if(isset($paginator)): ?>
  <div class="row">
    <nav class="paging-navigation" role="navigation">
      <h4 class="sr-only">Navigation</h4>
      <ul class="pagination">
        <?= isset($paginator) ? $paginator : ''; ?>
      </ul>
    </nav>
  </div>
<?php endif; ?>

<script src='<?= App::$app->router()->UrlTo('js/simple/list.min.js'); ?>' type="text/javascript"></script>
