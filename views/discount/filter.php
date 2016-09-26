<?php if(isset($filter_products)): ?>
<div class="panel panel-default form-row prod_sel_category_panel" data-filter="<?= $destination;?>">
    <div class="col-sm-12">
        <div class="panel-heading">
            <label style="font-size: 12px;">
                <input type="radio" name="sel_fabrics" id="sel_fabrics1" value="1" class="input-checkbox" <?= $data['sel_fabrics'] == "1" ? 'checked' : ''?>>
                All fabrics
            </label>
            <label style="font-size: 12px;">
                <input type="radio" name="sel_fabrics" id="sel_fabrics2" value="2" class="input-checkbox" <?= $data['sel_fabrics'] == "2" ? 'checked' : ''?>>
                All selected fabrics *
            </label>
            <label style="font-size: 12px;">
                <input type="radio" name="sel_fabrics" id="sel_fabrics3" value="3" class="input-checkbox" <?= $data['sel_fabrics'] == "3" ? 'checked' : ''?>>
                All selected categories *
            </label>
            <label style="font-size: 12px;">
                <input type="radio" name="sel_fabrics" id="sel_fabrics4" value="4" class="input-checkbox" <?= $data['sel_fabrics'] == "4" ? 'checked' : ''?>>
                All selected manufacturers *
            </label>
            <label style="font-size: 12px;">* - i.e. use the item selected below</label>
            <hr>
        </div>
        <div class="panel-body">
            <ul class="prod_sel_category">
                <?php foreach($filter_products as $key=>$name): ?>
                <li class="prod_sel_category_item row">
                    <div class="col-sm-11">
                        <div class="row"><span class="prod_sel_category_item_lab"><?= $name;?></span>
                        </div>
                        <input name="<?= ($filter_type !== 'users')?'filter_products':'users'?>[]" type="hidden" value="<?= $key;?>">
                    </div>
                    <span data-rem_row class="rem_cat">×</span>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="panel-footer">
            <a href="<?= $filter_type; ?>" data-destination="<?= $destination;?>" data-title="<?= $title;?>" name="edit_filter" class="button alt">Add</a>
        </div>
    </div>
</div>
<?php endif; ?>