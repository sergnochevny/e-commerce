<?php if(isset($filter_products)): ?>
<div class="panel panel-default form-row prod_sel_category_panel">
    <div class="col-sm-12">
        <div class="panel-body">
            <ul class="prod_sel_category">
                <?php foreach($filter_products as $key=>$name): ?>
                <li class="prod_sel_category_item row">
                    <div class="col-sm-11">
                        <div class="row"><span class="prod_sel_category_item_lab"><?= $name;?></span>
                        </div>
                        <input name="<?= ($filter_type !== 'users')?'filter_products':'users'?>[]" type="hidden" value="<?= $key;?>">
                    </div>
                    <span class="rem_cat">×</span>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="panel-footer">
            <a href="<?= $filter_type; ?>" name="edit_filter" class="button alt">Add</a>
        </div>
    </div>
</div>
<?php endif; ?>