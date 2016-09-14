<?php

class Controller_User extends Controller_Controller
{

    public function user()
    {
        $this->main->test_access_rights();
        $this->get_main_users_list();
        $this->main->view_admin('users');
    }

    public function users_list()
    {
        $this->main->test_access_rights();
        $this->get_main_users_list();
        $this->main->view_layout('users_list');
    }

    private function get_main_users_list()
    {
        $this->main->test_access_rights();
        $model = new Model_User();

        $page = !empty(_A_::$app->get('page')) ? $model->validData(_A_::$app->get('page')) : 1;
        $this->template->vars('page', $page);

        $per_page = 12;

        $total = $model->get_total_count_users();

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);

        $rows = $model->get_users_list($start, $per_page);

        ob_start();
            $base_url = _A_::$app->router()->UrlTo('/');
            foreach ($rows as $row) {
                $row[30] = gmdate("F j, Y, g:i a", $row[30]);
                include('./views/html/users_list.php');
            }
            $user_list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('main_users_list', $user_list);

        $paginator = new Controller_Paginator($this->main);
        $paginator->user_paginator($total, $page);

    }

    function del_user()
    {
        $this->main->test_access_rights();
        $model = new Model_User();
        $page_id = $model->validData(_A_::$app->get('page'));
        $user_id = $model->validData(_A_::$app->get('id'));
        $model->del_user($user_id);

        $this->users_list();
    }

    private function _save_edit_user()
    {
        $result = false;
        $model = new Model_User();
        include('include/save_edit_user_post.php');
        $user_id = !is_null(_A_::$app->get('user_id')) ? _A_::$app->get('user_id') : null;
        if (!empty($user_id)) {
            if (empty($user_email)) {
                $error = ['Identify email field!!!'];
                $this->template->vars('error', $error);
            } else {
                if ($model->user_exist($user_email, $user_id)) {
                    $error[] = 'User with this email already exists!!!';
                    $this->template->vars('error', $error);
                } else {
                    if (empty($user_first_name) || empty($user_last_name) || (empty($user_address) && empty($user_address2)) ||
                        empty($user_country{0}) || empty($user_zip) || empty($user_telephone) || (($user_Same_as_billing == 0) && (
                                empty($user_s_first_name) || empty($user_s_last_name) || (empty($user_s_address) && empty($user_s_address2)) ||
                                empty($user_s_country{0}) || empty($user_s_zip)
                            )
                        )
                    ) {

                        $error = ['Please fill in all required fields (marked with * )'];
                        $error1 = [];
                        $error2 = [];

                        if (empty($user_first_name)) $error1[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
                        if (empty($user_last_name)) $error1[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
                        if ((empty($user_address) && empty($user_address2))) $error1[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
                        if (empty($user_country{0})) $error1[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
                        if (empty($user_zip)) $error1[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';
                        if (empty($user_telephone)) $error1[] = '<pre>&#9;Identify <b>Telephone</b> field!!!</pre>';
                        if (count($error1) > 0) {
                            if (count($error) > 0) $error[] = '';
                            $error[] = 'BILLING INFORMATION:';
                            $error = array_merge($error, $error1);
                        }
                        if ($user_Same_as_billing == 0) {

                            if (empty($user_s_first_name)) $error2[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
                            if (empty($user_s_last_name)) $error2[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
                            if ((empty($user_s_address) && empty($user_s_address2))) $error2[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
                            if (empty($user_s_country{0})) $error2[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
                            if (empty($user_s_zip)) $error2[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';

                            if (count($error2) > 0) {
                                if (count($error) > 0) $error[] = '';
                                $error[] = 'SHIPPING INFORMATION:';
                                $error = array_merge($error, $error2);
                            }
                        }
                        $this->template->vars('error', $error);

                    } else {

                        $result = $model->update_user_data($user_Same_as_billing, $user_email, $user_first_name, $user_last_name, $user_organization,
                            $user_address, $user_address2, $user_state, $user_city, $user_country, $user_zip, $user_telephone,
                            $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name, $s_organization, $user_s_address,
                            $user_s_address2, $user_s_city, $user_s_state, $user_s_country, $user_s_zip, $user_s_telephone, $user_s_fax,
                            $user_s_email, $user_id);

                        if ($result) {
                            if (!is_null(_A_::$app->session['_']) && ($user_id == _A_::$app->session('_'))) {
                                $user = $model->get_user_by_id($user_id);
                                if (isset($user)) {
                                    $_u = _A_::$app->session('user', null);
                                    _A_::$app->session('user', $user);
                                }
                            }

                            if (!empty($user_create_password)) {
                                if ($user_confirm_password == $user_create_password) {
                                    $model_auth = new Model_Auth();
                                    $salt = $model_auth->generatestr();
                                    $password = $model_auth->hash_($user_create_password, $salt, 12);
                                    $check = $model_auth->check($user_create_password, $password);
                                    if ($password == $check) {
                                        $result = $model->update_password($password, $user_id);
                                        if ($result) {
                                            $warning = ['All data saved successfully!!!'];
                                            $this->template->vars('warning', $warning);
                                        } else {
                                            $error = [mysql_error()];
                                            $this->template->vars('error', $error);
                                        }
                                    }
                                } else {
                                    $error = ['Password and Confirm Password must be identical!!!'];
                                    $this->template->vars('error', $error);
                                }
                            } else {
                                $warning = ['All data saved successfully!!!'];
                                $this->template->vars('warning', $warning);
                            }
                        } else {
                            $error = [mysql_error()];
                            $this->template->vars('error', $error);
                        }
                    }
                }
            }
        }

        if ($result) {
            $userInfo = $model->get_user_data($user_id);
        } else {
            $userInfo = array(
                'email' => $user_email,
                'bill_firstname' => $user_first_name,
                'bill_lastname' => $user_last_name,
                'bill_organization' => $user_organization,
                'bill_address1' => $user_address,
                'bill_address2' => $user_address2,
                'bill_province' => $user_state,
//                    'bill_province_other' => $rowsni['bill_province_other'],
                'bill_city' => $user_city,
                'bill_country' => $user_country,
                'bill_postal' => $user_zip,
                'bill_phone' => $user_telephone,
                'bill_fax' => $user_fax,
                'bill_email' => $user_bil_email,
                'Same_as_billingSame_as_billing' => $user_Same_as_billing,
                'ship_firstname' => $user_s_first_name,
                'ship_lastname' => $user_s_last_name,
                'ship_organization' => $s_organization,
                'ship_address1' => $user_s_address,
                'ship_address2' => $user_s_address2,
                'ship_city' => $user_s_city,
                'ship_province' => $user_s_state,
//                    'ship_province_other' => $rowsni['ship_province_other'],
                'ship_country' => $user_s_country,
                'ship_postal' => $user_s_zip,
                'ship_phone' => $user_s_telephone,
                'ship_fax' => $user_s_fax,
                'ship_email' => $user_s_email
            );
        }

        $userInfo['bill_list_countries'] = $this->list_countries($userInfo['bill_country']);
        $userInfo['ship_list_countries'] = $this->list_countries($userInfo['ship_country']);
        $userInfo['bill_list_province'] = $this->list_province($userInfo['bill_country'], $userInfo['bill_province']);
        $userInfo['ship_list_province'] = $this->list_province($userInfo['ship_country'], $userInfo['ship_province']);

        $this->template->vars('userInfo', $userInfo);

        return $result;
    }

    private function list_countries($select = null)
    {
        $list = '';
        $maddress = new Model_Address();
        $countries = $maddress->get_countries_all();
        ob_start();
        foreach ($countries as $country) {
            $value = $country['id'];
            $title = $country['name'];
            $selected = isset($select) && ($select == $country['id']);
            include('views/address/select_countries_options.php');
        }
        $list = ob_get_contents();
        ob_end_clean();
        return $list;
    }

    private function list_province($country, $select = null)
    {
        $list = '';
        if (isset($country) && !empty($country{0})) {
            $maddress = new Model_Address();
            $provincies = $maddress->get_country_province($country);
            ob_start();
            foreach ($provincies as $province) {
                $value = $province['id'];
                $title = $province['name'];
                $selected = isset($select) && ($select == $province['id']);
                include('views/address/select_countries_options.php');
            }
            $list = ob_get_contents();
            ob_end_clean();
        }
        return $list;

    }

    public function get_province_list()
    {
        $list = '';
        if (!is_null(_A_::$app->get('country'))) {
            $country = _A_::$app->get('country');
            $list = $this->list_province($country);
        }
        echo '<option selected disabled>Select Province</option>';
        echo $list;
    }

    private function _edit_user()
    {
        $model = new Model_User();
        $user_id = $model->validData(_A_::$app->get('user_id'));
        $userInfo = $model->get_user_data($user_id);

        $userInfo['bill_list_countries'] = $this->list_countries($userInfo['bill_country']);
        $userInfo['ship_list_countries'] = $this->list_countries($userInfo['ship_country']);
        $userInfo['bill_list_province'] = $this->list_province($userInfo['bill_country'], $userInfo['bill_province']);
        $userInfo['ship_list_province'] = $this->list_province($userInfo['ship_country'], $userInfo['ship_province']);

        $prms['page'] = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : '1';
        $this->template->vars('back_url', _A_::$app->router()->UrlTo('users', $prms));
        $this->template->vars('userInfo', $userInfo);
    }

    private function _edit_user_form()
    {
        $this->main->view_layout('user/edit_user_form');
    }

    private function _new_user()
    {
        $prms['page'] = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : '1';
        $this->template->vars('back_url', _A_::$app->router()->UrlTo('users', $prms));

        $userInfo = array(
            'email' => '',
            'bill_firstname' => '',
            'bill_lastname' => '',
            'bill_organization' => '',
            'bill_address1' => '',
            'bill_address2' => '',
            'bill_province' => '',
//                    'bill_province_other' => $rowsni['bill_province_other'],
            'bill_city' => '',
            'bill_country' => '',
            'bill_postal' => '',
            'bill_phone' => '',
            'bill_fax' => '',
            'bill_email' => '',
            'ship_firstname' => '',
            'ship_lastname' => '',
            'ship_organization' => '',
            'ship_address1' => '',
            'ship_address2' => '',
            'ship_city' => '',
            'ship_province' => '',
//                    'ship_province_other' => $rowsni['ship_province_other'],
            'ship_country' => '',
            'ship_postal' => '',
            'ship_phone' => '',
            'ship_fax' => '',
            'ship_email' => ''
        );

        $userInfo['bill_list_countries'] = $this->list_countries($userInfo['bill_country']);
        $userInfo['ship_list_countries'] = $this->list_countries($userInfo['ship_country']);
        $userInfo['bill_list_province'] = $this->list_province($userInfo['bill_country'], $userInfo['bill_province']);
        $userInfo['ship_list_province'] = $this->list_province($userInfo['ship_country'], $userInfo['ship_province']);

        $this->template->vars('userInfo', $userInfo);
    }

    private function _new_user_form()
    {
        $prms['page'] = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : '1';
        $this->template->vars('back_url', _A_::$app->router()->UrlTo('users', $prms));
        $this->main->view_layout('new_user_form');
    }

    private function _save_new_user()
    {
        $result = false;
        $model = new Model_User();
        include('include/save_edit_user_post.php');
        $timestamp = time();
        if (empty($user_email)) {
            $error[] = 'Identify email field!!!';
            $this->template->vars('error', $error);
        } else {
            if ($model->user_exist($user_email)) {
                $error[] = 'User with this email already exists!!!';
                $this->template->vars('error', $error);
            } else {
                if (empty($user_create_password) || empty($user_confirm_password) || ($user_confirm_password <> $user_create_password)
                    || empty($user_first_name) || empty($user_last_name) || (empty($user_address) && empty($user_address2)) ||
                    empty($user_country{0}) || empty($user_zip) || empty($user_telephone) || (($user_Same_as_billing == 0) && (
                            empty($user_s_first_name) || empty($user_s_last_name) || (empty($user_s_address) && empty($user_s_address2)) ||
                            empty($user_s_country{0}) || empty($user_s_zip)
                        )
                    )
                ) {

                    $error = ['Please fill in all required fields (marked with * ):'];
                    $error1 = [];
                    $error2 = [];

                    if (empty($user_create_password) || empty($user_confirm_password)) $error[] = '<pre>&#9;Identify <b>Create Password</b> and <b>Confirm Password</b> field!!!</pre>';
                    if ($user_confirm_password !== $user_create_password) $error[] = '<pre>&#9;Fields <b>Create Password</b> and <b>Confirm Password</b> must be identical!!!</pre>';

                    if (empty($user_first_name)) $error1[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
                    if (empty($user_last_name)) $error1[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
                    if ((empty($user_address) && empty($user_address2))) $error1[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
                    if (empty($user_country{0})) $error1[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
                    if (empty($user_zip)) $error1[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';
                    if (empty($user_telephone)) $error1[] = '<pre>&#9;Identify <b>Telephone</b> field!!!</pre>';

                    if (count($error1) > 0) {
                        if (count($error) > 0) $error[] = '';
                        $error[] = 'BILLING INFORMATION:';
                        $error = array_merge($error, $error1);
                    }
                    if ($user_Same_as_billing == 0) {

                        if (empty($user_s_first_name)) $error2[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
                        if (empty($user_s_last_name)) $error2[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
                        if ((empty($user_s_address) && empty($user_s_address2))) $error2[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
                        if (empty($user_s_country{0})) $error2[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
                        if (empty($user_s_zip)) $error2[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';

                        if (count($error2) > 0) {
                            if (count($error) > 0) $error[] = '';
                            $error[] = 'SHIPPING INFORMATION:';
                            $error = array_merge($error, $error2);
                        }
                    }
                    $this->template->vars('error', $error);

                } else {
                    $model_auth = new Model_Auth();
                    $salt = $model_auth->generatestr();
                    $password = $model_auth->hash_($user_create_password, $salt, 12);
                    $check = $model_auth->check($user_create_password, $password);
                    if ($password == $check) {
                        $result = $model->insert_user($user_Same_as_billing, $user_email, $password, $user_first_name, $user_last_name, $user_organization,
                            $user_address, $user_address2, $user_state, $user_city, $user_country, $user_zip,
                            $user_telephone, $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name,
                            $s_organization, $user_s_address, $user_s_address2, $user_s_city, $user_s_state,
                            $user_s_country, $user_s_zip, $user_s_telephone, $user_s_fax, $user_s_email, $timestamp);
                        if ($result) {
                            _A_::$app->get('user_id') = mysql_insert_id();
                            $warning = ['Data saved successfully!!!'];
                            $this->template->vars('warning', $warning);
                        } else {
                            $error[] = mysql_error();
                            $this->template->vars('error', $error);
                        }
                    } else {
                        $error[] = 'Password and Confirm Password must be identical!!!';
                        $this->template->vars('error', $error);
                    }
                }
            }
        }
        if (!$result) {
            $userInfo = array(
                'email' => $user_email,
                'bill_firstname' => $user_first_name,
                'bill_lastname' => $user_last_name,
                'bill_organization' => $user_organization,
                'bill_address1' => $user_address,
                'bill_address2' => $user_address2,
                'bill_province' => $user_state,
//                    'bill_province_other' => $rowsni['bill_province_other'],
                'bill_city' => $user_city,
                'bill_country' => $user_country,
                'bill_postal' => $user_zip,
                'bill_phone' => $user_telephone,
                'bill_fax' => $user_fax,
                'bill_email' => $user_bil_email,
                'Same_as_billing' => $user_Same_as_billing,
                'ship_firstname' => $user_s_first_name,
                'ship_lastname' => $user_s_last_name,
                'ship_organization' => $s_organization,
                'ship_address1' => $user_s_address,
                'ship_address2' => $user_s_address2,
                'ship_city' => $user_s_city,
                'ship_province' => $user_s_state,
//                    'ship_province_other' => $rowsni['ship_province_other'],
                'ship_country' => $user_s_country,
                'ship_postal' => $user_s_zip,
                'ship_phone' => $user_s_telephone,
                'ship_fax' => $user_s_fax,
                'ship_email' => $user_s_email
            );

            $userInfo['bill_list_countries'] = $this->list_countries($userInfo['bill_country']);
            $userInfo['ship_list_countries'] = $this->list_countries($userInfo['ship_country']);
            $userInfo['bill_list_province'] = $this->list_province($userInfo['bill_country'], $userInfo['bill_province']);
            $userInfo['ship_list_province'] = $this->list_province($userInfo['ship_country'], $userInfo['ship_province']);

            $this->template->vars('userInfo', $userInfo);
        }

        return ($result);
    }

    function edit_user()
    {
        $this->main->test_access_rights();
        $this->main->template->vars('action', _A_::$app->router()->UrlTo('save_edit_user', ['user_id' => _A_::$app->get('user_id')]));
        $this->main->template->vars('title', 'EDIT USER');
        $this->_edit_user();
        $this->main->view_admin('edit');
    }

    function new_user()
    {
        $this->main->test_access_rights();
        $this->template->vars('action', _A_::$app->router()->UrlTo('save_new_user'));
        $this->template->vars('title', 'NEW USER');
        $this->_new_user();
        $this->main->view_admin('new');
    }

    function save_edit_user()
    {
        $this->main->test_access_rights();
        $this->main->template->vars('action', _A_::$app->router()->UrlTo('user/save_edit', ['user_id' => _A_::$app->get('user_id')]));
        $this->main->template->vars('title', 'EDIT USER');
        $this->_save_edit_user();
        $this->_edit_user_form();
    }

    function save_new()
    {
        $this->main->test_access_rights();
        $this->main->template->vars('action', _A_::$app->router()->UrlTo('user/save_new'));
        $this->main->template->vars('title', 'NEW USER');
        $this->_save_new_user();
        $this->_new_user_form();
    }

    public function registration()
    {
        $this->main->template->vars('title', 'REGISTRATION USER');
        $this->main->template->vars('action', _A_::$app->router()->UrlTo('user/save_registration'));
        $prms = null;
        if (!is_null(_A_::$app->get('url'))) {
            $prms['url'] = _A_::$app->get('url');
        }
        $this->template->vars('back_url', _A_::$app->router()->UrlTo('authorization/user', $prms), true);
        $this->_new_user();
        $this->main->view('user/new_user');
    }

    function save_registration()
    {
        $prms = null;
        if (!$this->_save_new_user()) {
            $this->template->vars('title', 'REGISTRATION USER');
            $this->template->vars('action', _A_::$app->router()->UrlTo('user/save_registration'));
            $this->_new_user_form();
        } else {
            $user_id = _A_::$app->get('user_id');
            $this->template->vars('title', 'CHANGE REGISTRATION DATA');
            if (!is_null(_A_::$app->get('url'))) {
                $prms['url'] = _A_::$app->get('url');
            }
            $this->template->vars('back_url', _A_::$app->router()->UrlTo('authorization/user', $prms), true);
            $this->template->vars('action', _A_::$app->router()->UrlTo('user/save_edit_registration_data'), true);

            $userInfo = (new Model_User())->get_user_data($user_id);

            $userInfo['bill_list_countries'] = $this->list_countries($userInfo['bill_country']);
            $userInfo['ship_list_countries'] = $this->list_countries($userInfo['ship_country']);
            $userInfo['bill_list_province'] = $this->list_province($userInfo['bill_country'], $userInfo['bill_province']);
            $userInfo['ship_list_province'] = $this->list_province($userInfo['ship_country'], $userInfo['ship_province']);

            $this->sendWelcomeEmail($userInfo['email']);

            $this->template->vars('userInfo', $userInfo);
            $this->_edit_user_form();
//            $url = $base_url . '/authorization';
//            $this->redirect($url);
        }
    }

    function save_edit_registration_data()
    {
        $authorization = new Controller_Authorization($this->main);

        if (!$authorization->is_user_logged()) {
            $this->redirect(_A_::$app->router()->UrlTo('/'));
        }

        $user_id = $authorization->get_user_from_session();
        _A_::$app->get('user_id', $user_id);
        $this->template->vars('action', _A_::$app->router()->UrlTo('/user/save_edit_registration_data'));
        $this->template->vars('title', 'CHANGE REGISTRATION DATA');
        $this->_save_edit_user();
        $this->_edit_user_form();
    }

    public function change_registration_data()
    {
        $authorization = new Controller_Authorization($this->main);
        if ($authorization->is_user_logged()) {
            $user_id = $authorization->get_user_from_session();
            _A_::$app->get('user_id', $user_id);
            $action = _A_::$app->router()->UrlTo('user/save_edit_registration_data');
            $this->template->vars('action', $action);
            $title = 'CHANGE REGISTRATION DATA';
            $this->template->vars('title', $title);
            $this->_edit_user();

            $url = '';
            if (!is_null(_A_::$app->get('url'))) {
                $url = _A_::$app->router()->UrlTo(base64_decode(urldecode(_A_::$app->get('url'))));
            }

            $this->template->vars('back_url', _A_::$app->router()->UrlTo(((strlen($url) > 0) ? $url : 'shop')), true);

            $this->main->view('user/edit_user');
        }

        $this->redirect(_A_::$app->router()->UrlTo('/'));
    }

    function sendWelcomeEmail($email)
    {

        $headers = "From: \"I Luv Fabrix\"<info@iluvfabrix.com>\n";
        $subject = "Thank you for registering with iluvfabrix.com";

        $body = "Thank you for registering with www.iluvfabrix.com.\n";
        $body .= "\n";
        $body .= "As a new user, you will get 20% off your first purchase (which you may use any time in the first year) unless we have a sale going on for a discount greater than 20%, in which case you get the greater of the two discounts.\n";
        $body .= "\n";
        $body .= "We will, from time to time, inform you by email of various time limited specials on the iluvfabrix site.  If you wish not to receive these emails, please respond to this email with the word Unsubscribe in the subject line.\n";
        $body .= "\n";
        $body .= "Once again, thank you.........and enjoy shopping for World Class Designer Fabrics & Trims on iluvfabrix.com.\n";

        mail($email, $subject, $body, $headers);
    }

    public function modify_accounts_password()
    {
        $per_page = 200;
        $page = 1;

        $muser = new Model_User();
        $model_auth = new Model_Auth();
        $total = $muser->get_total_count_users();
        $count = 0;
        while ($page <= ceil($total / $per_page)) {
            $start = (($page++ - 1) * $per_page);
            $rows = $muser->get_users_list($start, $per_page);
            foreach ($rows as $row) {
                $id = $row['aid'];
                $current_password = $row['password'];
                if (!strpos('$2a$12$', $current_password)) {
                    $salt = $model_auth->generatestr();
                    $password = $model_auth->hash_($current_password, $salt, 12);
                    $check = $model_auth->check($current_password, $password);
                    if ($password == $check) $muser->update_password($password, $id);
                }
            }
            $count += count($rows);
            echo $count;
        }
    }
}