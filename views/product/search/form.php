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
          <div class="col-xs-12">
            <div class="form-row">
                <label>Colour Name:</label>
                <input type="text" class="input-text" placeholder="Like ..." name="search[]"
                       value="<?= isset($search['colour']) ? $search['colour'] : '' ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6 col-sm-4">
            <div class="form-row">
                <label for="discount_on">
                  <input type="checkbox" id="discount_on" name="search[]"
                    value="<?= isset($search['']) ? $search[''] : '' ?>">
                  Status on/off
                </label>
            </div>
          </div>
          <div class="col-xs-6 col-sm-4">
            <div class="form-row">
                <label for="discount_on">
                  <input type="checkbox" id="discount_on" name="search[]"
                    value="<?= isset($search['']) ? $search[''] : '' ?>">
                  Multiple
                </label>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-row">
                <label for="discount_on">
                  <select name="" id="">
                    <option>Coupon Type</option>
                    <option value="">Coupon 1</option>
                    <option value="">Coupon 2</option>
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
                  <input type="text" id="discount_starts" class="input-text" name="search[]"
                    value="<?= isset($search['']) ? $search[''] : '' ?>">
                </label>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
                <label for="discount_on">
                  Ends at:
                  <input type="text" id="discount_ends" class="input-text" name="search[]"
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