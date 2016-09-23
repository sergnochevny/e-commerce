<?php if (isset($filter)): ?>
    <ul class="filter_sel prod_sel_category">
        <?php foreach ($filter as $row): ?>
            <li class="prod_sel_category_item">
                <div class="col-sm-8">
                    <div class="row">

                    </div>
                </div>
                <label>
                    <input name="<?= $type; ?>[]" type="checkbox" value="<?= $row[0]?>" <?= in_array($row[0], $selected) ? 'checked' : '' ?>>
                    <?= $row[1]; ?>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>