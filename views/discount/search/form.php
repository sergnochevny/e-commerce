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
          <div class="col-xs-6 col-sm-4">
            <div class="form-row">
              <select name="" id="">
                <option>Select Coupon Status</option>
                <option value="">Enabled</option>
                <option value="">Disabled</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-4">
            <div class="form-row">
              <select name="" id="">
                <option>Multiple</option>
                <option value="">Yes</option>
                <option value="">No</option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
                <label for="discount_on">
                  <input type="text" class="input-text" placeholder="Coupon details">
                </label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <div class="form-row">
                <label for="discount_on">
                  Starts at:
                  <input type="text" id="discount_starts" class="input-text" name="search[]" placeholder="Chose start date"
                    value="<?= isset($search['']) ? $search[''] : '' ?>">
                </label>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
                <label for="discount_on">
                  Ends at:
                  <input type="text" id="discount_ends" class="input-text" name="search[]" placeholder="Chose end date"
                         value="<?= isset($search['']) ? $search[''] : '' ?>">
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