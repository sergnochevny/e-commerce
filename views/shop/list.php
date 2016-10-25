<?php if (isset($page_title)) { ?>
  <div class="col-xs-12 text-center">
    <h2><?= $page_title; ?></h2>
  </div>
<?php } ?>

<div class="row">
  <div class="col-xs-12 search-result-header">

    <div class="row">
      <div class="col-sm-6">
        <?= isset($search) ? '<p class="">Search query: <b>' . $search . '</b></p>' : '' ?>
      </div>
      <div class="col-sm-6 search-result-container text-right">
        <span class="search-result">Showing <?= $count_rows; ?> results</span>
      </div>
    </div>

  </div>
</div>


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
  ?>

</p>
<div class="row">
  <div class="col-xs-12">
    <?= isset($annotation) ? '<p class="annotation">' . $annotation . '</p>' : '';?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="row products">
        <?= $rows; ?>
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