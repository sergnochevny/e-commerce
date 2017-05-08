<div class="col-xs-12">

  <?php if(isset($page_title)) : ?>
    <div class="col-xs-12 text-center afterhead-row">
      <?php if(!empty($user_name)) : ?>
        <h3 class="welcome">
          <span class="welcome-message">Welcome back,</span>
          <span class="user_name"><?= $user_name; ?></span>
        </h3>
      <?php endif; ?>
      <h1 class="page-title sb"><?= $page_title; ?></h1>
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
          <?php /** @noinspection PhpUndefinedMethodInspection */
            /** @noinspection PhpUndefinedMethodInspection */
            /** @noinspection PhpUndefinedMethodInspection */
            /** @noinspection PhpUndefinedMethodInspection */
            /** @noinspection PhpUndefinedMethodInspection */
            if(!empty(_A_::$app->get('cat')) || !empty(_A_::$app->get('mnf')) ||
              !empty(_A_::$app->get('ptrn')) || !empty(_A_::$app->get('clr')) || !is_null(_A_::$app->get('prc'))
            ) : ?>
              <p class="woocommerce-result-count">
                <?php
                  /** @noinspection PhpUndefinedMethodInspection */
                  if(!empty(_A_::$app->get('cat'))) {
                    echo 'CATEGORY: ' . $category_name;
                  }
                  /** @noinspection PhpUndefinedMethodInspection */
                  if(!empty(_A_::$app->get('mnf'))) {
                    echo 'MANUFACTURER: ' . $mnf_name;
                  }
                  /** @noinspection PhpUndefinedMethodInspection */
                  if(!empty(_A_::$app->get('ptrn'))) {
                    echo 'PATTERN: ' . $ptrn_name;
                  }
                  /** @noinspection PhpUndefinedMethodInspection */
                  if(!empty(_A_::$app->get('clr'))) {
                    echo 'COLOR: ' . $color_name;
                  }
                  /** @noinspection PhpUndefinedMethodInspection */
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

</div>

<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/formsimple/list.min.js'); ?>' type="text/javascript"></script>
