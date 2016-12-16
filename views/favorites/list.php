<?php if (isset($page_title)) { ?>
  <div class="col-xs-12 text-center afterhead-row">
    <h3 class="page-title"><?= $page_title; ?></h3>
  </div>
<?php } ?>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">
    <div class="row">
      <div class="col-sm-4">
      </div>
      <div class="col-sm-8 search-result-container text-right">
        <span class="search-result">Showing <?= $count_rows; ?> results</span>
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

<div class="row">
  <div class="col-xs-12">
    <nav class="paging-navigation" role="navigation">
      <h4 class="sr-only">Navigation</h4>
      <ul class="pagination">
        <?= isset($paginator) ? $paginator : ''; ?>
      </ul>
    </nav>
  </div>
</div>