<?php if (isset($filter)): ?>
    <ul class="filter_sel">
        <?php foreach ($filter as $row): ?>
            <li>
                <label>
                    <input name="<?= $type; ?>[]" type="checkbox" value="<?= $row[0]?>" <?= in_array($row[0], $selected) ? 'checked' : '' ?>>
                    <?= $row[1]; ?>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>