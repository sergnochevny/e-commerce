<?php if(isset($warning)) { ?>
  <div class="col-xs-12 alert-success danger">
    <?php foreach($warning as $msg) {
      echo $msg . "<br/>";
    } ?>
  </div>
<?php }
  if(isset($error)) { ?>
    <div class="col-xs-12 alert-danger danger">
      <?php foreach($error as $msg) {
        echo $msg . "<br/>";
      } ?>
    </div>
  <?php }
  $prms = null;
  if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
?>

<div class="col-xs-12 text-center">
  <h2>Blog</h2>
</div>

<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">

    <div class="row">
      <div class="col-sm-6 action-button-add">
        <a href="<?= _A_::$app->router()->UrlTo('blog/add', $prms); ?>" data-modify class="btn button">
          ADD NEW POST
        </a>
      </div>
      <div class="col-sm-6 search-result-container text-right">
        <span class="search-result">Showing <?= $count_rows; ?> results</span>
      </div>
    </div>

  </div>
</div>

<div class="row">
  <div class="col-xs-12 data-view">
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


<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/list.js'); ?>' type="text/javascript"></script>
