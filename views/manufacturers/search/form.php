<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-search"></i></div>
            <div class="col-xs-10 search-result-list comment-text">
              <?=isset($search['manufacturer'])?'<div class="label label-search-info">Like: '.$search['manufacturer'].'</div>':''?>
              <?= isset($search['active']) ? '<a data-search_reset title="Reset search" href="javascript:void(\'\')" class="button reset">&times;</a>' : '' ?>
            </div>
            <b class="sr-ds"><i class="fa fa-chevron-right"></i></b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">
        <div class="col-xs-12">
          <div class="form-row">
            <div class="row">
              <label>Manufacturer Name:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[manufacturer]"
                     value="<?= isset($search['manufacturer']) ? $search['manufacturer'] : '' ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-sm-12">
            <a data-search_submit class="button pull-right" href="<?= $action ?>">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

