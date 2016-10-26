<link rel="stylesheet" type="text/css" href="<?php _A_::$app->router('views/css/blog.css') ?>">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <article class="page type-page status-publish entry">
        <h1 class="entry-title">I Luv Fabrix Blog</h1>
        <div id="content" class="entry-content">
          <?=$list?>
        </div>
      </article>
      <nav class="paging-navigation" role="navigation">
        <h4 class="sr-only">Post navigation</h4>
        <ul class="pagination">
          <?= isset($paginator) ? $paginator : ''; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/blog.js'); ?>' type="text/javascript"></script>