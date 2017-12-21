<?php

use app\core\App;

?>
<?php include(APP_PATH. '/views/messages/alert-boxes.php'); ?>
<div class="col-xs-12 text-center">
  <h1 class="page-title">Synonyms Lookup Table</h1>
</div>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">
    <div class="row">
      <div class="col-xs-5 action-button-add">
        <a href="<?= App::$app->router()->UrlTo('synonyms/add'); ?>" data-modify class="button">
          ADD SYNONYMS
        </a>
      </div>
      <div class="col-xs-7 search-result-container text-right">
        <span class="search-result">Showing <?= $count_rows; ?> results</span>
        <?= isset($show_by) ? $show_by : ''; ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <?= $list; ?>
  </div>
</div>

<div class="row">
  <nav class="paging-navigation" role="navigation">
    <h4 class="sr-only">Navigation</h4>
    <ul class="pagination">
      <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
  </nav>
</div>

<script src='<?= App::$app->router()->UrlTo('js/simple/list.min.js'); ?>' type="text/javascript"></script>
