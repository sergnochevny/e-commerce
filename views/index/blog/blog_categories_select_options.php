<?php
foreach ($categories as $category) {
    ?>
    <option value="<?php echo $category['group_id'];?>" <?php echo (in_array($category['group_id'], $selected_categories) ? 'selected' :'' ) ?> ><?php echo $category['name'];?></option>
    <?php
}
?>