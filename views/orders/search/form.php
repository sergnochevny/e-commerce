<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-search"></i></div>
            <div class="col-xs-10 search-result-list comment-text">
              <?= isset($search['trid']) ? '<div class="label label-search-info">TR ID: ' . $search['trid'] . '</div>' : '' ?>
              <?= isset($search['name']) ? '<div class="label label-search-info">Customer: ' . $search['name'] . '</div>' : '' ?>
              <?= isset($search['name']) ? '<div class="label label-search-info">Date from: ' . $search['name'] . '</div>' : '' ?>
              <?= isset($search['name']) ? '<div class="label label-search-info">Date to: ' . $search['name'] . '</div>' : '' ?>
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
              <label>Order transaction code:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[trid]"
                     value="<?= isset($search['trid']) ? $search['trid'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label>Customer:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[full_name]"
                     value="<?= isset($search['name']) ? $search['name'] : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges from:</label>
              <input type="text" class="input-text" id="date-from" placeholder="Chose start date"
                     name="search[order_date][]"
                     value="<?= isset($search['order_date']) ? $search['order_date'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges to:</label>
              <input type="text" class="input-text" id="date-to" placeholder="Chose end date"
                     name="search[order_date][]"
                     value="<?= isset($search['order_date']) ? $search['order_date'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Status:</label>
              <select name="search[status]" id="">
                <option value selected>Any</option>
                <option value="0" <?= isset($search['status']) && $search['status'] == 0 ? 'selected' : '' ?>>In
                  process
                </option>
                <option value="1" <?= isset($search['status']) && $search['status'] == 1 ? 'selected' : '' ?>>
                  Completed
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-sm-12">
            <a data-search_submit class="button pull-right">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>' type="text/javascript"></script>