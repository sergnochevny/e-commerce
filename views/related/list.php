<?php

use app\core\App;

?>
<div class="col-xs-12">
  <div class="col-xs-12 text-center">
    <div class="h3" style="padding-bottom: 15px">Select Related Fabrics</div>
  </div>

  <?= isset($search_form) ? $search_form : '' ?>

  <div class="row">
    <div class="col-xs-12 search-result-header text-right">
      <span class="search-result">Showing <?= $count_rows; ?> results</span>
      <?= isset($show_by) ? $show_by : ''; ?>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="row related_products">
        <?= $list; ?>
      </div>
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

  <?php if(isset($paginator)): ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="text-center">
          <a data-related_add_ok class="button" href="ok" style="width: 150px;">Ok</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/formsimple/list.min.js'), 4, true);?>
