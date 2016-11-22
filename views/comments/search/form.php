<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
            <div class="h4 col-xs-10 search-result-list comment-text">
              <?= isset($search['a.title']) ? '<div class="label label-search-info">Post Title Like: ' . $search['a.title'] . '</div>' : '' ?>
              <?= isset($search['b.email']) ? '<div class="label label-search-info">Sender email: ' . $search['b.email'] . '</div>' : '' ?>
              <?= !empty($search['a.dt']['from']) ? '<div class="label label-search-info">Date from: ' . $search['a.dt']['from'] . '</div>' : '' ?>
              <?= !empty($search['a.dt']['to']) ? '<div class="label label-search-info">Date to: ' . $search['a.dt']['to'] . '</div>' : '' ?>
              <?php if(isset($search['a.moderated'])): ?>
                <div class="label label-search-info">
                  Moderated: <?= isset($search['a.moderated']) && $search['a.moderated'] == 1 ? 'YES' : 'NO' ?>
                </div>
              <?php endif; ?>
              <?= isset($search['active']) ? '<a data-search_reset title="Reset search" href="javascript:void(0)" class="reset"><i class="fa fa-2x fa-times" aria-hidden="true"></i></a>' : '' ?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-2x fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-row">
              <label>User:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[b.email]"
                     value="<?= isset($search['b.email']) ? $search['b.email'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label>Title:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[a.title]"
                     value="<?= isset($search['a.title']) ? $search['a.title'] : '' ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges from:</label>
              <input type="text" class="input-text" id="date-from" placeholder="Chose start date"
                     name="search[a.dt][from]"
                     value="<?= isset($search['a.dt']['from']) ? $search['a.dt']['from'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges to:</label>
              <input type="text" class="input-text" id="date-to" placeholder="Chose end date"
                     name="search[a.dt][to]"
                     value="<?= isset($search['a.dt']['to']) ? $search['a.dt']['to'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Status:</label>
              <select name="search[a.moderated]" id="">
                <option value <?= !isset($search['a.moderated']) ? 'selected' : '' ?>>Any</option>
                <option
                  value="0" <?= isset($search['a.moderated']) && $search['a.moderated'] == 0 ? 'selected' : '' ?>>
                  Hidden
                </option>
                <option
                  value="1" <?= isset($search['a.moderated']) && $search['a.moderated'] == 1 ? 'selected' : '' ?>>
                  Moderated
                </option>
              </select>
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
<script src="<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>"></script>