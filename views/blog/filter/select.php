<div class="filter_select_panel row form-row">
  <div class="col-xs-12 search_panel">
    <div class="row">
      <div class="col-md-10 col-xs-10">
        <input type="text" data-input_filter_search class="input-text" name="filter_select_search_<?= $filter_type; ?>"
               placeholder="Type for search ..." value="<?= isset($search) ? $search : ''; ?>">
      </div>
      <div class="col-md-2 col-xs-2 text-right">
        <a href="filter" data-filter-type="<?= $filter_type; ?>" data-filter-search class="button"
           data-destination="<?= $destination; ?>">
          <i class="fa fa-search" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="col-xs-12 select_panel">
    <?php if(isset($filter)): ?>
      <ul class="filter_sel sel_item">
        <?php if(isset($filter_data_start) && ($filter_data_start > 0)): ?>
          <li class="select_item">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="row text-center">
                <a href="filter" data-filter-type="<?= $filter_type; ?>" data-move="up"
                   data-filter-search class="button-move"
                   title="back..."
                   data-destination="<?= $destination; ?>">
                  <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </li>
        <?php endif; ?>
        <?php foreach($filter as $row): ?>
          <li class="select_item">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="row">
                <label>
                  <input name="<?= $type; ?>[]" type="checkbox"
                         value="<?= $row[0] ?>" <?= in_array($row[0], $selected) ? 'checked' : '' ?>>
                  <?= $row[1]; ?>
                </label>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
        <?php
          if(isset($filter_data_start) && isset($total) && !((ceil($filter_data_start / FILTER_LIMIT) + 1) >= ceil($total / FILTER_LIMIT))):?>
            <li class="select_item">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row text-center">
                  <a href="filter" data-filter-type="<?= $filter_type; ?>" data-move="down"
                     data-filter-search class="button-move"
                     title="more..."
                     data-destination="<?= $destination; ?>">
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                  </a>
                </div>
              </div>
            </li>
          <?php endif; ?>
      </ul>
    <?php endif; ?>
  </div>
  <input type="hidden" name="filter_start_<?= $filter_type; ?>" value="<?= $filter_data_start; ?>">
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/ui.min.js'); ?>' type="text/javascript"></script>