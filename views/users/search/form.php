<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-2"><i class="fa fa-search"></i></div>
            <div class="col-xs-9 comment-text">
              <?= isset($search['pname']) ? '<span>Like: </span><b>' . $search['pname'] . '</b>' : '' ?>
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
              <label>User Email:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[email]"
                     value="<?= isset($search['email']) ? $search['email'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-8">
            <div class="form-row">
              <label>User First and/or Last Name:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[full_name]"
                     value="<?= isset($search['full_name']) ? $search['full_name'] : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-row">
              <label>Registration date ranges from:</label>
              <input type="text" class="input-text" placeholder="Chose start date" name="search[date_registered][from]"
                     value="<?= isset($search['date_registered']['from']) ? $search['date_registered']['from'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label>Registration date ranges to:</label>
              <input type="text" class="input-text" placeholder="Chose end date" name="search[date_registered][to]"
                     value="<?= isset($search['date_registered']['to']) ? $search['date_registered']['to'] : '' ?>">
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
