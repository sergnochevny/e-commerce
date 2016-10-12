<form action="<?= $action ?>" method="post" data-search>
  <div class="col-xs-12 panel panel-default search-panel">
    <div class="panel-heading">
      <div class="h4 search-container-title">
        <div class="row">
          <div class="col-xs-2">Search</div>
          <div class="col-xs-9 comment-text">
            <?=isset($search['cname'])?'<span class="red">Categories like </span><b>'.$search['cname'].'</b>':''?>
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
            <label>Category Name:</label>
            <input type="text" class="input-text" placeholder="Like ..." name="search[cname]"
                   value="<?= isset($search['cname']) ? $search['cname'] : '' ?>">
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
