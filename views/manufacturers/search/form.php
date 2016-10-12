<form action="<?= $action ?>" method="post" data-search>
  <div class="col-xs-12 panel panel-default search-panel">
    <div class="panel-heading">
      <div class="h4 search-container-title">
        <div class="row">
          <div class="col-xs-2">Search</div>
          <div class="col-xs-9 comment-text">
            <?=isset($search['manufacturer'])?'<span class="red">Manufacturers like </span><b>'.$search['manufacturer'].'</b>':''?>
          </div>
          <div class="col-xs-1">
            <b class="sr-ds">
              <i class="fa fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>
    </div>

    <div class="panel-body hidden">
      <div class="col-xs-12">
        <div class="form-row">
          <div class="row">
            <label>Pattern Name:</label>
            <input type="text" class="input-text" placeholder="Like ..." name="search[manufacturer]"
                   value="<?= isset($search['manufacturer']) ? $search['manufacturer'] : '' ?>">
          </div>
        </div>
      </div>
    </div>

    <div class="panel-footer hidden">
      <a data-search_submit class="btn submit pull-right">Search</a>
      <a data-search_reset class="btn reset">Reset</a>
    </div>
  </div>
</form>
