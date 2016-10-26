<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-search"></i></div>
            <div class="col-xs-10 search-result-list comment-text">
              <?= isset($search['email']) ? '<div class="label label-search-info">Email: ' . $search['email'] . '</div>' : '' ?>
              <?= isset($search['full_name']) ? '<div class="label label-search-info">Email: ' . $search['full_name'] . '</div>' : '' ?>
              <?= isset($search['full_name']) ? '<div class="label label-search-info">Date from: ' . $search['full_name'] . '</div>' : '' ?>
              <?= isset($search['full_name']) ? '<div class="label label-search-info">Date to: ' . $search['full_name'] . '</div>' : '' ?>
              <?= isset($search['active']) ? '<a data-search_reset title="Reset search" class="button reset">&times;</a>' : '' ?>
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
              <input type="text" id="date-from" class="input-text" placeholder="Chose start date" name="search[date_registered][from]"
                     value="<?= isset($search['a.dt']['from']) ? $search['a.dt']['from'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label>Registration date ranges to:</label>
              <input type="text" id="date-to" class="input-text" placeholder="Chose end date" name="search[date_registered][to]"
                     value="<?= isset($search['a.dt']['to']) ? $search['a.dt']['to'] : '' ?>">
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