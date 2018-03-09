<?php

use app\core\App;

?>
<div class="col-xs-12 pull-right">
  <div class="row text-center">
    <h3 class="page-title sb">Price</h3>
  </div>
</div>
<?= isset($search_form) ? $search_form : '' ?>
<div class="col-xs-12 search-result-header search-result-container text-right">
  <div class="row">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
    <?= isset($show_by) ? $show_by : ''; ?>
  </div>
</div>
<div class="col-xs-12">
  <div class="row filters-wrap">
    <div class="products filters-groups">
      <?= $list; ?>
    </div>
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
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/formsimple/list.min.js'), 4, true);?>
