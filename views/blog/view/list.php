<?php

use app\core\App;

?>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">
    <div class="row">
      <div class="col-sm-6">
        <?php if(!empty(App::$app->get('cat'))): ?>
          <p class="woocommerce-result-count">
            CATEGORY: <?= $category_name ?> '<br/>
          </p>
        <?php endif; ?>
      </div>
      <div class="col-sm-6 search-result-container text-right">
        <span class="search-result">Showing <?= $count_rows; ?> results</span>
        <?= isset($show_by) ? $show_by : ''; ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="products">
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
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/formsimple/list.min.js'), 5, true);?>
