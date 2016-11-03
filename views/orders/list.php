<?php
  $user_id = _A_::$app->get('aid');
  $is_admin = Controller_Admin::is_logged();
  $prms = null;
  if(!is_null(_A_::$app->get('page'))) {
    $prms['page'] = _A_::$app->get('page');
  }
  if(!is_null(_A_::$app->get('back'))) {
    $back_url = _A_::$app->router()->UrlTo(_A_::$app->get('back'), $prms);
  }
  include_once 'views/messages/alert-boxes.php';
?>

<?php if(isset($back_url)): ?>
  <div class="col-sm-12">
    <div class="row afterhead-row">
      <div class="col-sm-2 back_button_container">
        <div class="row">
          <a id="back_url" href="<?= $back_url; ?>" class="button back_button">Back</a>
        </div>
      </div>
      <div class="col-sm-8 text-center">
        <div class="row">
          <h3
            class="page-title"><?= (isset($user_id) && !$is_admin) ? $rows[0]['username'] : ((!$is_admin) ? 'My' : '') ?>
            Orders</h3>
        </div>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
<?php else: ?>
  <div class="col-xs-12 text-center afterhead-row">
    <h3 class="page-title"><?= (isset($user_id) && !$is_admin) ? $rows[0]['username'] : ((!$is_admin) ? 'My' : '') ?>
      Orders</h3>
  </div>
<?php endif; ?>
<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header">

    <div class="row">
      <div class="col-sm-6 action-button-add">

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

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/list.js'); ?>' type="text/javascript"></script>
