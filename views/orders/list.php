<?php
  $user_id = _A_::$app->get('aid');
  $is_admin = Controller_Admin::is_logged();
  include_once 'views/messages/alert-boxes.php';
?>

<?php if(isset($back_url)): ?>
  <div class="col-xs-12">
    <div class="row afterhead-row">
      <div class="col-sm-2 back_button_container">
        <div class="row">
          <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            Back
          </a>
        </div>
      </div>
      <div class="col-sm-8 text-center">
        <div class="row">
          <h3
            class="page-title"><?= (isset($user_id) && !$is_admin) ? $data[0]['username'] : ((!$is_admin) ? 'My' : '') ?>
            Orders</h3>
        </div>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
<?php else: ?>
  <div class="col-xs-12 text-center afterhead-row">
    <h3 class="page-title"><?= (isset($user_id) && !$is_admin) ? $data[0]['username'] : ((!$is_admin) ? 'My' : '') ?>
      Orders</h3>
  </div>
<?php endif; ?>
<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
  <div class="col-xs-12 search-result-header text-right">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
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

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/list.min.js'); ?>' type="text/javascript"></script>
