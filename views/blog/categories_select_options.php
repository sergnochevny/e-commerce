<?php foreach ($categories as $category) { ?>
    <option value="<?= $category['group_id'];?>"
        <?= (in_array($category['group_id'], $selected_categories) ? 'selected' : '') ?> >
        <?= $category['name'];?>
    </option>
<?php } ?>