<?php

use app\core\App;

?>
<div class="col-xs-12 text-center">
  <h1 class="page-title">Comments</h1>
</div>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-container text-right">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
    <?= isset($show_by) ? $show_by : ''; ?>
  </div>
</div>

<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>

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
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/simple/list.min.js'), 4);?>
