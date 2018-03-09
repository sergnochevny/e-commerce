<?php

use app\core\App;
use classes\helpers\UserHelper;

?>
<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
            <div class="h4 col-xs-10 search-result-list comment-text">
              <?php if(isset($search['a.trid'])): ?>
                <div class="label label-search-info">Transaction: <?= $search['a.trid'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['username'])): ?>
                <div class="label label-search-info">Customer: <?= $search['username'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['a.status'])): ?>
                <div class="label label-search-info">
                  Status: <?= isset($search['a.status']) && $search['a.status'] == 1 ? 'Completed' : 'In progress' ?>
                </div>
              <?php endif; ?>
              <?php if(!empty($search['a.order_date']['from'])): ?>
                <div class="label label-search-info">
                  Date from: <?= $search['a.order_date']['from']  ?></div>
              <?php endif; ?>
              <?php if(!empty($search['a.order_date']['to'])): ?>
                <div class="label label-search-info">
                  Date to: <?= $search['a.order_date']['to']  ?></div>
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
              <label>Order transaction code:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[a.trid]"
                     value="<?= isset($search['a.trid']) ? $search['a.trid'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6" <?= UserHelper::is_logged()?'disabled':''?>>
            <div class="form-row">
              <label>Customer:</label>
              <input type="text" class="input-text" <?= UserHelper::is_logged()?'disabled':''?> placeholder="Like ..." name="search[username]"
                     value="<?= isset($search['username']) ? $search['username'] : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges from:</label>
              <input type="text" class="input-text" id="date-from" placeholder="Chose start date"
                     name="search[a.order_date][from]"
                     value="<?= isset($search['a.order_date']['from']) ? $search['a.order_date']['from'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Date ranges to:</label>
              <input type="text" class="input-text" id="date-to" placeholder="Chose end date"
                     name="search[a.order_date][to]"
                     value="<?= isset($search['a.order_date']['to']) ? $search['a.order_date']['to'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Status:</label>
              <select name="search[a.status]" id="">
                <option value <?= !isset($search['a.status'])?'selected':''?>>Any</option>
                <option value="0" <?= isset($search['a.status']) && $search['a.status'] == 0 ? 'a.selected' : '' ?>>In
                  process
                </option>
                <option value="1" <?= isset($search['a.status']) && $search['a.status'] == 1 ? 'selected' : '' ?>>
                  Completed
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-xs-12">
            <a data-search_submit class="button pull-right" href="<?= $action ?>">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/search.min.js'), 4, true);?>