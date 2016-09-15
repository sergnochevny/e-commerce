<?php
$category_id = $model->validData(_A_::$app->get('category_id'));
$data = $model->validData(_A_::$app->post('category'));
$post_category_name = mysql_real_escape_string($data);
$post_display_order = $model->validData(_A_::$app->post('display_order'));
$data = $model->validData(_A_::$app->post('seo'));
$post_category_seo = mysql_real_escape_string($data);
$post_category_ListStyle = $model->validData(!is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : 0);
$post_category_ListNewItem = $model->validData(!is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : 0);
?>