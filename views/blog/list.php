<?php include_once 'views/messages/alert-boxes.php';?>

<div class="col-xs-12 text-center afterhead-row">
  <h3 class="page-title">Blog</h3>
</div>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">

    <div class="row">
      <div class="col-xs-6 action-button-add">
        <a href="<?= _A_::$app->router()->UrlTo('blog/add'); ?>" data-modify class="button">
          ADD NEW POST
        </a>
      </div>
      <div class="col-xs-6 search-result-container text-right">
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
  <div class="col-xs-12">

    <nav class="paging-navigation" role="navigation">
      <h4 class="sr-only">Navigation</h4>
      <ul class="pagination">
        <?= isset($paginator) ? $paginator : ''; ?>
      </ul>
    </nav>

  </div>
</div>


<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/list.min.js'); ?>' type="text/javascript"></script>
