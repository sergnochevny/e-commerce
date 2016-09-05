<?php

class Controller_User extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function users()
    {
        $this->main->test_access_rights();

        $this->get_main_users_list();
        $this->main->view_admin('user/users');
    }

    function users_list()
    {
        $this->main->test_access_rights();

        $this->get_main_users_list();
        $this->main->view_layout('user/users_list');
    }

    function get_main_users_list()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $this->template->vars('page', $page);

        $per_page = 12;

        $muser = new Model_User();
        $total = $muser->get_total_count_users();

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);

        $rows = $muser->get_users_list($start, $per_page);

        ob_start();
        $base_url = BASE_URL;
        foreach ($rows as $row) {
            $row[30] = gmdate("F j, Y, g:i a", $row[30]);
            include('./views/html/users_list.php');
        }
        $user_list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('main_users_list', $user_list);

        include_once('controllers/_paginator.php');
        $paginator = new Controller_Paginator($this->main);
        $paginator->user_paginator($total, $page);

    }

    function del_user()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['page']);
        $page_id = $userInfo['data'];
        $userInfo = $model->validData($_GET['id']);
        $user_id = $userInfo['data'];
        $muser = new Model_User();
        $muser->del_user($user_id);

        $this->users_list();
    }

    private function _save_edit_user()
    {
        $result = false;
        $model = new Model_Users();
        include('include/save_edit_user_post.php');
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
        if (!empty($user_id)) {
            if (empty($user_email)) {
                $error = ['Identify email field!!!'];
                $this->template->vars('error', $error);
            }else{
                $muser = new Model_User();
                if ($muser->user_exist($user_email, $user_id)) {
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

                        $result = $muser->update_user_data($user_Same_as_billing, $user_email, $user_first_name, $user_last_name, $user_organization,
                            $user_address, $user_address2, $user_state, $user_city, $user_country, $user_zip, $user_telephone,
                            $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name, $s_organization, $user_s_address,
                            $user_s_address2, $user_s_city, $user_s_state, $user_s_country, $user_s_zip, $user_s_telephone, $user_s_fax,
                            $user_s_email, $user_id);

                        if ($result) {
                            if (isset($_SESSION['_']) && ($user_id == $_SESSION['_'])) {
                                $user = $muser->get_user_by_id($user_id);
                                if (isset($user)) {
                                    unset($_SESSION['user']);
                                    $_SESSION['user'] = $user;
                                }
                            }

                            if (!empty($user_create_password)) {
                                if ($user_confirm_password == $user_create_password) {
                                    $model_auth = new Model_Auth();
                                    $salt = $model_auth->generatestr();
                                    $password = $model_auth->hash_($user_create_password, $salt, 12);
                                    $check = $model_auth->check($user_create_password, $password);
                                    if ($password == $check) {
                                        $result = $muser->update_password($password, $user_id);
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
            $userInfo = $model->get_user_edit_data($user_id);
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
            include('views/index/address/select_countries_options.php');
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
                include('views/index/address/select_countries_options.php');
            }
            $list = ob_get_contents();
            ob_end_clean();
        }
        return $list;

    }

    public function get_province_list()
    {
        $list = '';
        if (isset($_GET['country'])) {
            $country = $_GET['country'];
            $list = $this->list_province($country);
        }
        echo '<option selected disabled>Select Province</option>';
        echo $list;
    }

    private function _edit_user()
    {
        $base_url = BASE_URL;
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['user_id']);
        $user_id = $userInfo['data'];

//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/users?page=';
        if (!empty($_GET['page'])) {
            $back_url .= $_GET['page'];
        } else
            $back_url .= '1';
//        }

        $userInfo = $model->get_user_edit_data($user_id);

        $userInfo['bill_list_countries'] = $this->list_countries($userInfo['bill_country']);
        $userInfo['ship_list_countries'] = $this->list_countries($userInfo['ship_country']);
        $userInfo['bill_list_province'] = $this->list_province($userInfo['bill_country'], $userInfo['bill_province']);
        $userInfo['ship_list_province'] = $this->list_province($userInfo['ship_country'], $userInfo['ship_province']);

        $this->template->vars('back_url', $back_url);
        $this->template->vars('userInfo', $userInfo);
    }

    private function _edit_user_form()
    {
        $this->main->view_layout('user/edit_user_form');
    }

    private function _new_user()
    {
        $model = new Model_Users();

//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/users?page=';
        if (!empty($_GET['page'])) {
            $back_url .= $_GET['page'];
        } else
            $back_url .= '1';
//        }

        $this->template->vars('back_url', $back_url);

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
        $model = new Model_Users();

//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/users?page=';
        if (!empty($_GET['page'])) {
            $back_url .= $_GET['page'];
        } else
            $back_url .= '1';
//        }

        $this->template->vars('back_url', $back_url);

        $this->main->view_layout('user/new_user_form');
    }

    private function _save_new_user()
    {
        $result = false;
        $model = new Model_Users();
        include('include/save_edit_user_post.php');
        $timestamp = time();
        if(empty($user_email)){
            $error[] = 'Identify email field!!!';
            $this->template->vars('error', $error);
        } else {
            $muser = new Model_User();
            if ($muser->user_exist($user_email)) {
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
                        $result = $muser->insert_user($user_Same_as_billing, $user_email, $password, $user_first_name, $user_last_name, $user_organization,
                            $user_address, $user_address2, $user_state, $user_city, $user_country, $user_zip,
                            $user_telephone, $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name,
                            $s_organization, $user_s_address, $user_s_address2, $user_s_city, $user_s_state,
                            $user_s_country, $user_s_zip, $user_s_telephone, $user_s_fax, $user_s_email, $timestamp);
                        if ($result) {
                            $_GET['user_id'] = mysql_insert_id();
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
        $base_url = BASE_URL;
        $this->main->test_access_rights();
        $action = $base_url . '/save_edit_user?user_id=' . $_GET['user_id'];
        $this->template->vars('action', $action);
        $title = 'EDIT USER';
        $this->template->vars('title', $title);
        $this->_edit_user();
        $this->main->view_admin('user/edit_user');
    }

    function new_user()
    {
        $base_url = BASE_URL;
        $this->main->test_access_rights();
        $action = $base_url . '/save_new_user';
        $this->template->vars('action', $action);
        $title = 'NEW USER';
        $this->template->vars('title', $title);
        $this->_new_user();
        $this->main->view_admin('user/new_user');
    }

    function save_edit_user()
    {
        $base_url = BASE_URL;
        $this->main->test_access_rights();
        $action = $base_url . '/save_edit_user?user_id=' . $_GET['user_id'];
        $this->template->vars('action', $action);
        $title = 'EDIT USER';
        $this->template->vars('title', $title);
        $this->_save_edit_user();
        $this->_edit_user_form();
    }

    function save_new_user()
    {
        $base_url = BASE_URL;
        $this->main->test_access_rights();
        $action = $base_url . '/save_new_user';
        $this->template->vars('action', $action);
        $title = 'NEW USER';
        $this->template->vars('title', $title);
        $this->_save_new_user();
        $this->_new_user_form();
    }

    public function registration_user()
    {
        $base_url = BASE_URL;
        $title = 'REGISTRATION USER';
        $this->template->vars('title', $title);
        $action = $base_url . '/save_registration_user';
        $this->template->vars('action', $action);
        $back_url = $base_url . '/user_authorization';
        if (isset($_GET['url'])) {
            $back_url .= '?url=' . $_GET['url'];
        }
        $this->template->vars('back_url', $back_url, true);
        $this->_new_user();
        $this->main->view('user/new_user');
    }

    function save_registration_user()
    {
        $base_url = BASE_URL;
        if (!$this->_save_new_user()) {
            $title = 'REGISTRATION USER';
            $this->template->vars('title', $title);
            $action = $base_url . '/save_registration_user';
            $this->template->vars('action', $action);
            $this->_new_user_form();
        } else {
            $model = new Model_Users();
            $user_id = $_GET['user_id'];

            $title = 'CHANGE REGISTRATION DATA';
            $this->template->vars('title', $title);
            $back_url = $base_url . '/user_authorization';
            if (isset($_GET['url'])) {
                $back_url .= '?url=' . $_GET['url'];
            }
            $this->template->vars('back_url', $back_url, true);
            $action = $base_url . '/save_edit_registration_data';
            $this->template->vars('action', $action, true);

            $userInfo = $model->get_user_edit_data($user_id);

            $userInfo['bill_list_countries'] = $this->list_countries($userInfo['bill_country']);
            $userInfo['ship_list_countries'] = $this->list_countries($userInfo['ship_country']);
            $userInfo['bill_list_province'] = $this->list_province($userInfo['bill_country'], $userInfo['bill_province']);
            $userInfo['ship_list_province'] = $this->list_province($userInfo['ship_country'], $userInfo['ship_province']);

            $email = $userInfo['email'];
            $this->sendWelcomeEmail($email);

            $this->template->vars('userInfo', $userInfo);
            $this->_edit_user_form();
//            $url = $base_url . '/authorization';
//            $this->redirect($url);
        }
    }

    function save_edit_registration_data()
    {
        $base_url = BASE_URL;
        include_once('controllers/_authorization.php');
        $authorization = new Controller_Authorization($this->main);
        if ($authorization->is_user_logged()) {
            $user_id = $authorization->get_user_from_session();
            $_GET['user_id'] = $user_id;
            $action = $base_url . '/save_edit_registration_data';
            $this->template->vars('action', $action);
            $title = 'CHANGE REGISTRATION DATA';
            $this->template->vars('title', $title);
            $this->_save_edit_user();
            $this->_edit_user_form();
        } else {
            $url = $base_url;
            $this->redirect($base_url);
        }
    }

    public function change_registration_data()
    {
        $base_url = BASE_URL;

        include_once('controllers/_authorization.php');
        $authorization = new Controller_Authorization($this->main);

        if ($authorization->is_user_logged()) {
            $user_id = $authorization->get_user_from_session();
            $_GET['user_id'] = $user_id;
            $action = $base_url . '/save_edit_registration_data';
            $this->template->vars('action', $action);
            $title = 'CHANGE REGISTRATION DATA';
            $this->template->vars('title', $title);
            $this->_edit_user();

            $back_url = '';
            if(isset($_GET['url'])){
                $back_url = base64_decode(urldecode($_GET['url']));
            }
            $back_url = $base_url . ((strlen($back_url) > 0) ? $back_url : '/shop');
            $this->template->vars('back_url', $back_url, true);

            $this->main->view('user/edit_user');
        } else {
            $url = $base_url;
            $this->redirect($base_url);
        }

    }

    function sendWelcomeEmail($email){

        $headers = "From: \"I Luv Fabrix\"<info@iluvfabrix.com>\n";
        $subject = "Thank you for registering with iluvfabrix.com";

        $body = "Thank you for registering with www.iluvfabrix.com.\n";
        $body .= "\n";
        $body .= "As a new user, you will get 20% off your first purchase (which you may use any time in the first year) unless we have a sale going on for a discount greater than 20%, in which case you get the greater of the two discounts.\n";
        $body .= "\n";
        $body .= "We will, from time to time, inform you by email of various time limited specials on the iluvfabrix site.  If you wish not to receive these emails, please respond to this email with the word Unsubscribe in the subject line.\n";
        $body .= "\n";
        $body .= "Once again, thank you.........and enjoy shopping for World Class Designer Fabrics & Trims on iluvfabrix.com.\n";

        mail($email, $subject,$body,$headers);
    }

}