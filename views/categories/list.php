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
  <h2>Categories</h2>
</div>

<?= isset($search_form) ? $search_form : '' ?>
<div class="row">
  <div class="col-xs-12 data-list-view">
    <div class="col-xs-12 data-list-view-header relative">
      <div class="col-xs-12 col-sm-4">
        <div class="row xs-text-center">
          <a href="<?= _A_::$app->router()->UrlTo('categories/add', $prms); ?>" data-modify class="btn button">
            ADD NEW CATEGORY
          </a>
        </div>
      </div>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 data-list-view-body">
        <?= $list; ?>
      </div>
    </div>
    <div class="col-md-12">
      <nav class="paging-navigation" role="navigation">
        <h4 class="sr-only">Navigation</h4>
        <ul class="pagination">
          <?= isset($paginator) ? $paginator : ''; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/list.js'); ?>' type="text/javascript"></script>
