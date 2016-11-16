<?php if (isset($page_title)) { ?>
  <div class="col-xs-12 text-center afterhead-row">
    <h2 class="page-title"><?= $page_title; ?></h2>
  </div>
<?php } ?>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12">
    <?= isset($annotation) ? '<p class="annotation inner-offset-bottom">' . $annotation . '</p>' : '';?>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 search-result-header">
    <div class="row">
      <div class="col-sm-8">
        <?php if (!empty(_A_::$app->get('cat')) || !empty(_A_::$app->get('mnf')) || !empty(_A_::$app->get('ptrn'))  || !empty(_A_::$app->get('clr'))) : ?>
        <p class="woocommerce-result-count">
          <?php
            if (!empty(_A_::$app->get('cat'))) {
              echo 'CATEGORY: ' . $category_name . '<br/>';
            }
            if (!empty(_A_::$app->get('mnf'))) {
              echo 'MANUFACTURER: ' . $mnf_name . '<br/>';
            }
            if (!empty(_A_::$app->get('ptrn'))) {
              echo 'PATTERN: ' . $ptrn_name . '<br/>';
            }
            if (!empty(_A_::$app->get('clr'))) {
              echo 'COLOUR: ' . $colour_name . '<br/>';
            }
          ?>
        </p>
        <?php endif; ?>
      </div>
      <div class="col-sm-4 search-result-container text-right">
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

<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/list.js'); ?>' type="text/javascript"></script>
