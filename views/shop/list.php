<?php

use app\core\App;

?>
<div class="col-xs-12">

  <?php if(isset($page_title)) : ?>
    <div class="col-xs-12 text-center">
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
        <div class="col-sm-offset-6 col-sm-6 search-result-container text-right">
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
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/formsimple/list.min.js'), 4);?>
