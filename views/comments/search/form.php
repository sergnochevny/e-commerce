<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-2"><i class="fa fa-search"></i></div>
            <div class="col-xs-9 comment-text">
              <?=isset($search['colour'])?'<span>Like: </span><b>'.$search['colour'].'</b>':''?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">
        <div class="row">
            <div class="col-xs-4">
            <div class="form-row">
              <label>User:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[colour]"
                     value="<?= isset($search['colour']) ? $search['colour'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>Title:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[colour]"
                     value="<?= isset($search['colour']) ? $search['colour'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>Status:</label>
              <select name="" id="">
                <option value="">Moderated</option>
                <option value="">Hidden</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label>Date ranges from:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[colour]"
                     value="<?= isset($search['colour']) ? $search['colour'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label>Date ranges to:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[colour]"
                     value="<?= isset($search['colour']) ? $search['colour'] : '' ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="panel-footer hidden">
        <a data-search_submit class="btn button pull-right">Search</a>
        <a data-search_reset class="btn reset">Reset</a>
      </div>
    </div>
  </div>
</form>
