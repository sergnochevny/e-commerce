<?php if(isset($search['firstpage'])) : ?>
  <div class="row">
    <div class="col-xs-12 col-sm-2 back_button_container">
      <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
        Back
      </a>
    </div>
    <div class="col-xs-12 col-sm-8 text-center">
      <div class="row">
        <h1 class="page-title"><?= $page_title; ?></h1>
      </div>
    </div>
    <div class="col-sm-2 text-center"></div>
  </div>
<?php elseif(isset($page_title)) : ?>
  <div class="col-xs-12 text-center">
    <h1 class="page-title"><?= $page_title; ?></h1>
  </div>
<?php endif; ?>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12">
    <?= isset($annotation) ? '<p class="annotation inner-offset-bottom">' . $annotation . '</p>' : ''; ?>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 search-result-header">
    <div class="row">
      <div class="col-sm-6">
        <?php if(!empty(_A_::$app->get('cat')) || !empty(_A_::$app->get('mnf')) ||
          !empty(_A_::$app->get('ptrn')) || !empty(_A_::$app->get('clr')) || !is_null(_A_::$app->get('prc'))
        ) : ?>
          <p class="woocommerce-result-count">
            <?php
              if(!empty(_A_::$app->get('cat'))) {
                echo 'CATEGORY: ' . $category_name;
              }
              if(!empty(_A_::$app->get('mnf'))) {
                echo 'MANUFACTURER: ' . $mnf_name;
              }
              if(!empty(_A_::$app->get('ptrn'))) {
                echo 'PATTERN: ' . $ptrn_name;
              }
              if(!empty(_A_::$app->get('clr'))) {
                echo 'COLOR: ' . $color_name;
              }
              if(!is_null(_A_::$app->get('prc'))) {
                echo 'PRICE: ' . ((isset($prc_from) && !empty($prc_from)) ? ' $' . number_format($prc_from, 2) : ' $0.00') . ((isset($prc_to) && !empty($prc_to)) ? ' - $' . number_format($prc_to, 2) : ' and above');
              }
            ?>
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

<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/list.min.js'); ?>' type="text/javascript"></script>
