<?php

use app\core\App;

?>
<div class="col-xs-12 text-center">
  <h1 class="page-title">Products</h1>
</div>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">

    <div class="row">
      <div class="col-xs-5 action-button-add">
        <a href="<?= App::$app->router()->UrlTo('product/add'); ?>" data-modify class="button">
          ADD PRODUCT
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
    <div class="row products">
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
