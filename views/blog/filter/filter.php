<?php if(isset($filters)): ?>
  <div class="panel panel-default form-row sel_panel" data-filter="<?= $destination; ?>">
    <div class="panel-body">
      <ul class="sel_item">
        <?php foreach($filters as $key => $value): ?>
          <li class="selected_item">
            <div class="<?= (!is_array($value)) ? 'col-sm-11 col-xs-11' : 'col-sm-8 col-xs-8' ?>">
              <div class="row">
                <span class="sel_item_lab"><?= is_array($value) ? $value[0] : $value; ?></span>
              </div>
              <?php if(!is_array($value)): ?>
                <input name="<?= $filter_type ?>[<?= $key; ?>]"
                       type="hidden" value="<?= $key; ?>">
              <?php endif; ?>
            </div>
            <?php if(is_array($value)): ?>
              <div class="col-sm-3 col-xs-3">
                <input class="input-text" name="<?= $filter_type ?>[<?= $key; ?>]" type="text"
                       value="<?= $value[1]; ?>">
              </div>
            <?php endif; ?>
            <div class="col-sm-1 col-xs-1 text-right">
              <div class="row"><span data-rem_row data-index="<?= $key ?>" class="rem_row">×</span></div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="panel-footer">
      <a href="<?= $filter_type; ?>" data-destination="<?= $destination; ?>" data-title="<?= $title; ?>"
         name="edit_filter" class="button alt">Add</a>
    </div>
  </div>
<?php endif; ?>