<?php $back_url = _A_::$app->router()->UrlTo('shop'); ?>

<div class="col-xs-12 col-sm-2 back_button_container">
  <div class="row">
    <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
      <i class="fa fa-angle-left" aria-hidden="true"></i>
      To Shop
    </a>
  </div>
</div>
<?php if(isset($view_title)) : ?>
  <div class="col-xs-12 col-sm-8 text-center">
    <h1 class="page-title sb"><?= $view_title; ?></h1>
  </div>
<?php endif; ?>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">
    <div class="row">
      <div class="col-xs-12 search-result-container text-right">
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

<div class="row">
  <nav class="paging-navigation" role="navigation">
    <h4 class="sr-only">Navigation</h4>
    <ul class="pagination">
      <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
  </nav>
</div>

<script src='<?= _A_::$app->router()->UrlTo('js/formsimple/list.min.js'); ?>' type="text/javascript"></script>
