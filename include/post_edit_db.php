<?php

$p_id = $model->validData(_A_::$app->get('p_id')) ? _A_::$app->get('p_id') : '';
$data = $model->validData(_A_::$app->post('desc')) ? _A_::$app->post('desc') : '';
$post_desc = mysql_real_escape_string($data);
$data = $model->validData(_A_::$app->post('mkey')) ? _A_::$app->post('mkey') : '';
$post_mkey = mysql_real_escape_string($data);
$data = $model->validData(_A_::$app->post('p_name')) ? _A_::$app->post('p_name') : '';
$post_tp_name = mysql_real_escape_string($data);
$post_product_num = $model->validData(_A_::$app->post('product_num')) ? _A_::$app->post('product_num') : '';
$post_width = $model->validData(_A_::$app->post('width')) ? _A_::$app->post('width') : '';
$post_p_yard = $model->validData(_A_::$app->post('p_yard')) ? _A_::$app->post('p_yard') : '';
$post_st_nom = $model->validData(_A_::$app->post('st_nom')) ? _A_::$app->post('st_nom') : '';
$post_hide_prise = $model->validData(!is_null(_A_::$app->post('hide_prise'))) ? _A_::$app->post('hide_prise') : '';
$post_dimens = $model->validData(_A_::$app->post('dimens')) ? _A_::$app->post('dimens') : '';
$post_curret_in = $model->validData(_A_::$app->post('curret_in')) ? _A_::$app->post('curret_in') : '';
$post_special = $model->validData(!is_null(_A_::$app->post('special'))) ? _A_::$app->post('special') : 0;
$post_weight = $model->validData(!is_null(_A_::$app->post('weight'))) ? _A_::$app->post('weight') : '';
$post_manufacturer = $model->validData(_A_::$app->post('manufacturer')) ? _A_::$app->post('manufacturer') : '';
$data = $model->validData(_A_::$app->post('new_color')) ? _A_::$app->post('new_color') : '';
$post_new_color = mysql_real_escape_string($data);
$post_colours = $model->validData(!is_null(_A_::$app->post('colours')))  ? _A_::$app->post('colours') : '';
$data = $model->validData(_A_::$app->post('new_pattern_type')) ? _A_::$app->post('new_pattern_type') : '';
$pattern_type = mysql_real_escape_string($data);
$post_short_desk = $model->validData(_A_::$app->post('short_desk')) ? _A_::$app->post('new_pattern_type') : '';
$data = stripslashes(_A_::$app->post('Long_description'));
$post_Long_description = mysql_real_escape_string(trim(htmlspecialchars($data)));
$post_fabric_1 = $model->validData(_A_::$app->post('fabric_1')) ? _A_::$app->post('fabric_1') : '';
$post_fabric_2 = $model->validData(_A_::$app->post('fabric_2')) ? _A_::$app->post('fabric_2') : '';
$post_fabric_3 = $model->validData(_A_::$app->post('fabric_3')) ? _A_::$app->post('fabric_3') : '';
$post_fabric_4 = $model->validData(_A_::$app->post('fabric_4')) ? _A_::$app->post('fabric_4') : '';
$post_fabric_5 = $model->validData(_A_::$app->post('fabric_5')) ? _A_::$app->post('fabric_5') : '';
$post_weight_cat = $model->validData(_A_::$app->post('weight_cat')) ? _A_::$app->post('weight_cat') : '';
$p_colors = !is_null(_A_::$app->post('colors')) ? _A_::$app->post('colors') : [];
$post_categori = !is_null(_A_::$app->post('categori')) ? _A_::$app->post('categori') : [];
$patterns = !is_null(_A_::$app->post('patterns')) ? _A_::$app->post('patterns') : [];
$data = $model->validData(_A_::$app->post('New_Manufacturer')) ? _A_::$app->post('New_Manufacturer') : '';
$New_Manufacturer = mysql_real_escape_string($data);
$post_vis = $model->validData(_A_::$app->post('vis')) ? _A_::$app->post('vis') : '' ;
$best = $model->validData(!is_null(_A_::$app->post('best')))  ? _A_::$app->post('best') : '0';
$piece = !is_null(_A_::$app->post('piece')) ? _A_::$app->post('piece') : '0';
$whole = !is_null(_A_::$app->post('whole')) ? _A_::$app->post('whole') : '0';
?>