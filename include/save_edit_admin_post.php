<?php
$login = Model_Admin::validData(!is_null(_A_::$app->post('login')) ? _A_::$app->post('login') : '');
$create_password = Model_Admin::validData(!is_null(_A_::$app->post('create_password')) ? _A_::$app->post('create_password') : '');
$confirm_password = Model_Admin::validData(!is_null(_A_::$app->post('confirm_password')) ? _A_::$app->post('confirm_password') : '');

?>