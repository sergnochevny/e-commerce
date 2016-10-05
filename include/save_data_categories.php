<?php
$category_id = _A_::$app->get('category_id');
$data = Model_Category::validData(_A_::$app->post('category'));
$post_category_name = mysql_real_escape_string($data);
$post_display_order = Model_Category::validData(_A_::$app->post('display_order'));
?>