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
          <div class="col-sm-6">
            <div class="form-row">
                <label>Product Name:</label>
                <input type="text" class="input-text" placeholder="Like ..." name="search[pname]"
                       value="<?= isset($search['pname']) ? $search['pname'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label for="">
                Select the status
                <select name="search[pvisible]" id="">
                  <option value selected>Any status</option>
                  <option value="0" <?= isset($search['pvisible']) && $search['pvisible'] == 0 ? 'selected' : '' ?>>Hidden</option>
                  <option value="1" <?= isset($search['pvisible']) && $search['pvisible'] == 1 ? 'selected' : '' ?>>Visible</option>
                </select>
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-row">
                <label for="discount_on">
                  Starts at:
                  <input placeholder="Chose start date" type="text" id="discount_starts" class="input-text" name="search[dt][starts]"
                    value="<?= isset($search['dt']['starts']) ? $search['dt']['starts'] : '' ?>">
                </label>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
                <label for="discount_on">
                  Ends at:
                  <input placeholder="Chose end date" type="text" id="discount_ends" class="input-text" name="search[dt][ends]"
                         value="<?= isset($search['dt']['ends']) ? $search['dt']['ends'] : '' ?>">
                </label>
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
<script src="<?= _A_::$app->router()->UrlTo('views/js/discount/search.js'); ?>"></script>