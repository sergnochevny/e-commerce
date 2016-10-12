<div class="container">
  <h3 class="page-title"><?= isset($title) ? $title : "Comments" ?></h3>
  <div id="content" class="main-content-inner" role="main"><?= $content ?></div>
  <nav role="navigation" class="paging-navigation">
    <h4 class="sr-only">Navigation</h4>
    <ul class='pagination'>
      <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
  </nav>
</div>

