<?php if(isset($warning)) { ?>
  <div class="col-xs-12 alert-success danger">
    <?php foreach($warning as $msg) { echo $msg . "<br/>"; } ?>
  </div>
<?php } if(isset($error)) { ?>
  <div class="col-xs-12 alert-danger danger">
    <?php foreach($error as $msg) { echo $msg . "<br/>"; }?>
  </div>
<?php }
  $prms = null;
  if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
?>

<?= isset($search_form) ? $search_form : '' ?>

<div class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 data-list-view panel panel-default">

      <div class="col-xs-12 panel-header data-list-view-header relative">

        <div class="col-xs-12 col-sm-8">
          <div class="row xs-text-center">
            <p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="row text-right xs-text-center">
            <a href="<?= _A_::$app->router()->UrlTo('categories/add',$prms); ?>" data-modify class="btn">
              ADD NEW CATEGORY
            </a>
          </div>
        </div>


      </div>
      <div class="panel-body data-list-view-body">
        <div class="row">
          <?= $list; ?>
        </div>
      </div>
      <div class="panel-footer">
        <nav class="paging-navigation" role="navigation">
          <h4 class="sr-only">Navigation</h4>
          <ul class="pagination">
            <?= isset($paginator) ? $paginator : ''; ?>
          </ul>
        </nav>
      </div>

    </div>
  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/list.js'); ?>' type="text/javascript"></script>
