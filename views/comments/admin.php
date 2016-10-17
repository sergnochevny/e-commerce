<div class="container">


  <div class="col-xs-12 text-center">
    <h2>Comments</h2>
  </div>

  <?= isset($search_form) ? $search_form : '' ?>

  <div class="row">
    <div class="col-xs-12 search-result-header">

      <div class="row">
        <div class="col-sm-6 col-sm-offset-6 search-result-container text-right">
          <span class="search-result">Showing <?= 321//$count_rows; ?> results</span>
        </div>
      </div>

    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 data-view">
      <?php include('views/comments/admin_list.php') ?>
    </div>
  </div>

  <div id="confirm_dialog" class="overlay"></div>
  <div class="popup">
    <div class="fcheck"></div>
    <a class="close" title="close">&times;</a>

    <div class="b_cap_cod_main">
      <p style="color: black;" class="text-center"><b id="dialog-text"></b></p>
      <br/>
      <div class="text-center" style="width: 100%">
        <a id="confirm_action">
          <input type="button" id="publish-comment" value="Yes confirm" class="button"/></a>
        <a id="confirm_no">
          <input type="button" value="No" class="button"/></a>
      </div>
    </div>
  </div>

  <div id="comment-view-dialog" class="overlay"></div>
  <div class="popup-view popup">
    <div class="fcheck"></div>
    <a href="#" class="close" title="close">&times;</a>

    <div class="" id="comment-view-dialog-data">
      <p style="color: black;" id="dialog-text"></p>
    </div>
  </div>
  <input type="hidden" id="href_update_comment" value="<?= _A_::$app->router()->UrlTo('comments/update') ?>">
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/comments/admin.js'); ?>' type="text/javascript"></script>