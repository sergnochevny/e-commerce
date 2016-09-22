<?php
$data = Model_Category::validData(!is_null(_A_::$app->post('seo')) ? _A_::$app->post('seo') : '');
$post_category_seo = mysql_real_escape_string($data);
$post_category_ListStyle = Model_Category::validData(!is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : 0);
$post_category_ListNewItem = Model_Category::validData(!is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : 0);
if ($post_category_ListStyle == "1") {
    $post_category_ListStyle = "1";
} else {
    $post_category_ListStyle = "0";
}
if ($post_category_ListNewItem == "1") {
    $post_category_ListNewItem = "1";
} else {
    $post_category_ListNewItem = "0";
}
?>