<?php if (isset($filters)): ?>
    <div class="panel panel-default form-row sel_panel" data-filter="<?= $destination; ?>">
        <div class="col-sm-12">
            <div class="panel-body">
                <ul class="sel_item">
                    <?php foreach ($filters as $key => $name): ?>
                        <li class="selected_item">
                            <div class="col-sm-11 col-xs-11">
                                <div class="row"><span class="sel_item_lab"><?= $name; ?></span></div>
                                <input name="<?= ($filter_type !== 'users') ? 'filter_products' : 'users' ?>[]"
                                       type="hidden" value="<?= $key; ?>">
                            </div>
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
    </div>
<?php endif; ?>