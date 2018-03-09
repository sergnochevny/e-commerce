<?php

use app\core\App;

?>
<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
            <div class="h4 col-xs-10 search-result-list comment-text">
              <?= isset($search['a.post_title']) ? '<div class="label label-search-info">Post Name Like: ' . $search['a.post_title'] . '</div>' : '' ?>
              <?= isset($search['b.group_id']) ? '<div class="label label-search-info">Category: ' . $search['categories'][$search['b.group_id']] . '</div>' : '' ?>
              <?= !empty($search['a.post_date']['from']) ? '<div class="label label-search-info">Date from: ' . $search['a.post_date']['from'] . '</div>' : '' ?>
              <?= !empty($search['a.post_date']['to']) ? '<div class="label label-search-info">Date to: ' . $search['a.post_date']['to'] . '</div>' : '' ?>
              <?= isset($search['a.post_status']) ?
                ($search['a.post_status'] == 'publish' ?
                  '<div class="label label-search-info">Status: Published</div>' :
                  '<div class="label label-search-info">Status: Hidden</div>'
                ) :
                ''
              ?>
              <?= isset($search['active']) ? '<a data-search_reset  href="javascript:void(0)" title="Reset search" class="reset"><i class="fa fa-2x fa-times" aria-hidden="true"></i></a>' : '' ?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-2x fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">
        <div class="row">
          <div class="col-sm-8">
            <div class="form-row">
              <label>Post title:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[a.post_title]"
                     value="<?= isset($search['a.post_title']) ? $search['a.post_title'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Chose Category Name:</label>
              <select name="search[b.group_id]" id="">
                <option value <?= !isset($search['b.group_id'])?'selected':''?>>Any</option>
                <?php foreach ($search['categories'] as $index => $category): ?>
                  <option
                    value="<?= $index ?>" <?= (isset($search['b.group_id']) && $index == $search['b.group_id']) ? 'selected' : '' ?>><?= $category ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges from:</label>
              <input type="text" class="input-text" id="date-from" placeholder="Chose start date"
                     name="search[a.post_date][from]"
                     value="<?= isset($search['a.post_date']['from']) ? $search['a.post_date']['from'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges to:</label>
              <input type="text" class="input-text" id="date-to" placeholder="Chose end date"
                     name="search[a.post_date][to]"
                     value="<?= isset($search['a.post_date']['to']) ? $search['a.post_date']['to'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Status:</label>
              <select name="search[a.post_status]" id="">
                <option value <?= !isset($search['a.post_status'])?'selected':''?>>Any</option>
                <option
                  value="0" <?= isset($search['a.post_status']) && $search['a.post_status'] == 0 ? 'selected' : '' ?>>
                  In process
                </option>
                <option
                  value="1" <?= isset($search['a.post_status']) && $search['a.post_status'] == 1 ? 'selected' : '' ?>>
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
            <a data-search_submit class="button pull-right" href="<?= $action ?>">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/search.min.js'), 4, true);?>