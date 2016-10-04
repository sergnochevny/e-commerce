<?php

  class Controller_Users extends Controller_Controller {

    private function get_list() {
      $page = !empty(_A_::$app->get('page')) ? Model_User::validData(_A_::$app->get('page')) : 1;
      $per_page = 12;
      $total = Model_User::get_total_count_users();
      if($page > ceil($total / $per_page))
        $page = ceil($total / $per_page);
      if($page <= 0)
        $page = 1;
      $start = (($page - 1) * $per_page);
      $rows = Model_User::get_users_list($start, $per_page);

      $this->template->vars('page', $page);
      ob_start();
      foreach($rows as $row) {
        $row[30] = gmdate("F j, Y, g:i a", $row[30]);
        $this->template->vars('row', $row);
        $this->template->view_layout('list_detail');
      }
      $user_list = ob_get_contents();
      ob_end_clean();
      $this->main->template->vars('main_users_list', $user_list);
      $this->main->template->vars('page', $page);
      (new Controller_Paginator($this->main))->paginator($total, $page, 'users', $per_page);
      $this->main->view_layout('list');
    }

    private function list_countries($select = null) {
      $list = '';
      $countries = Model_Address::get_countries_all();
      ob_start();
      foreach($countries as $country) {
        $this->template->vars('value', $country['id']);
        $this->template->vars('title', $country['name']);
        $this->template->vars('selected', isset($select) && ($select == $country['id']));
        $this->template->view_layout('address/select_countries_options');
      }
      $list = ob_get_contents();
      ob_end_clean();
      return $list;
    }

    private function get_province_list() {
      $list = '';
      if(!is_null(_A_::$app->get('country'))) {
        $country = _A_::$app->get('country');
        $list = $this->list_province($country);
      }
      echo '<option selected disabled>Select Province</option>';
      echo $list;
    }

    private function form_handling() {
      $method = _A_::$app->get('method');
      if($method == 'get_province_list') {
        $this->get_province_list();
      }
    }

    private function save(&$data) {
      $result = false;
      include('include/save_edit_user_post.php');
      $user_id = _A_::$app->get('user_id');

      $data = [
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
      ];

      if(empty($user_email)) {
        $error = ['Identify email field!!!'];
      } else {
        if(Model_User::user_exist($user_email, $user_id)) {
          $error[] = 'User with this email already exists!!!';
        } else {
          if(
            ((!isset($user_id)) && (empty($user_create_password) || empty($user_confirm_password))) ||
            ((!isset($user_id)) && ($user_confirm_password !== $user_create_password)) ||
            empty($user_first_name) ||
            empty($user_last_name) ||
            (empty($user_address) && empty($user_address2)) ||
            empty($user_country{0}) ||
            empty($user_zip) ||
            empty($user_telephone) ||
            (($user_Same_as_billing == 0) &&
              (empty($user_s_first_name) ||
                empty($user_s_last_name) ||
                (empty($user_s_address) && empty($user_s_address2)) ||
                empty($user_s_country{0}) || empty($user_s_zip)))
          ) {

            $error = ['Please fill in all required fields (marked with * )'];
            $error1 = [];
            $error2 = [];

            if((!isset($user_id)) && (empty($user_create_password) || empty($user_confirm_password)))
              $error[] = '<pre>&#9;Identify <b>Create Password</b> and <b>Confirm Password</b> field!!!</pre>';
            if((!isset($user_id)) && ($user_confirm_password !== $user_create_password))
              $error[] = '<pre>&#9;Fields <b>Create Password</b> and <b>Confirm Password</b> must be identical!!!</pre>';

            if(empty($user_first_name))
              $error1[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
            if(empty($user_last_name))
              $error1[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
            if((empty($user_address) && empty($user_address2)))
              $error1[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
            if(empty($user_country{0}))
              $error1[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
            if(empty($user_zip))
              $error1[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';
            if(empty($user_telephone))
              $error1[] = '<pre>&#9;Identify <b>Telephone</b> field!!!</pre>';
            if(count($error1) > 0) {
              if(count($error) > 0)
                $error[] = '';
              $error[] = 'BILLING INFORMATION:';
              $error = array_merge($error, $error1);
            }
            if($user_Same_as_billing == 0) {

              if(empty($user_s_first_name))
                $error2[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
              if(empty($user_s_last_name))
                $error2[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
              if((empty($user_s_address) && empty($user_s_address2)))
                $error2[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
              if(empty($user_s_country{0}))
                $error2[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
              if(empty($user_s_zip))
                $error2[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';

              if(count($error2) > 0) {
                if(count($error) > 0)
                  $error[] = '';
                $error[] = 'SHIPPING INFORMATION:';
                $error = array_merge($error, $error2);
              }
            }
          } else {
            if(isset($user_id)) {
              if(!empty($user_create_password)) {
                $password = $user_create_password;
                if($user_confirm_password == $user_create_password) {
                  $salt = Model_Auth::generatestr();
                  $password = Model_Auth::hash_($user_create_password, $salt, 12);
                  $check = Model_Auth::check($user_create_password, $password);
                } else {
                  $error = ['Password and Confirm Password must be identical!!!'];
                }
              } else $password = null;

              if(is_null($password) || (isset($check) && ($password == $check))) {
                try {
                  $u_id = Model_User::save($user_Same_as_billing, $user_email, $user_first_name,
                                           $user_last_name, $user_organization, $user_address, $user_address2,
                                           $user_state, $user_city, $user_country, $user_zip, $user_telephone,
                                           $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name,
                                           $s_organization, $user_s_address, $user_s_address2, $user_s_city,
                                           $user_s_state, $user_s_country, $user_s_zip, $user_s_telephone,
                                           $user_s_fax, $user_s_email, $password, $user_id);
                  if(!is_null($password)) Model_User::update_password($password, $user_id);

                  if(!is_null(_A_::$app->session('_')) && ($user_id == _A_::$app->session('_'))) {
                    $user = Model_User::get_user_by_id($u_id);
                    if(isset($user)) {
                      _A_::$app->setSession('user', $user);
                    }
                  }
                  $warning = ['All data saved successfully!!!'];
                  $result = true;
                  $data = null;
                } catch(Exception $e) {
                  $error[] = $e->getMessage();
                }
              }
            } else {

              $salt = Model_Auth::generatestr();
              $password = Model_Auth::hash_($user_create_password, $salt, 12);
              $check = Model_Auth::check($user_create_password, $password);
              if($password == $check) {
                try {
                  $u_id = Model_User::save($user_Same_as_billing, $user_email, $user_first_name,
                                           $user_last_name, $user_organization, $user_address, $user_address2,
                                           $user_state, $user_city, $user_country, $user_zip, $user_telephone,
                                           $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name,
                                           $s_organization, $user_s_address, $user_s_address2, $user_s_city,
                                           $user_s_state, $user_s_country, $user_s_zip, $user_s_telephone,
                                           $user_s_fax, $user_s_email, $password, $user_id);
                  _A_::$app->get('user_id', $u_id);
                  $warning = ['Data saved successfully!!!'];
                  $result = true;
                } catch(Exception $e) {
                  $error[] = $e->getMessage();
                }
              } else {
                $error[] = 'Password and Confirm Password must be identical!!!';
              }
            }
          }
        }
      }
      if(isset($warning)) $this->template->vars('warning', $warning);
      if(isset($error)) $this->template->vars('error', $error);

      return $result;
    }

    private function list_province($country, $select = null) {
      $list = '';
      if(isset($country) && !empty($country)) {
        $provincies = Model_Address::get_country_province($country);
        ob_start();
        foreach($provincies as $province) {
          $this->template->vars('value', $province['id']);
          $this->template->vars('title', $province['name']);
          $this->template->vars('selected', isset($select) && ($select == $province['id']));
          $this->template->view_layout('address/select_countries_options');
        }
        $list = ob_get_contents();
        ob_end_clean();
      }
      return $list;
    }

    /**
     * @export
     */
    public function users() {
      $this->main->test_access_rights();
      ob_start();
      $this->get_list();
      $list = ob_get_contents();
      ob_end_clean();
      $this->template->vars('list', $list);
      $this->main->view_admin('users');
    }

    /**
     * @export
     */
    public function del() {
      $this->main->test_access_rights();
      $user_id = _A_::$app->get('user_id');
      Model_User::del_user($user_id);
      $this->get_list();
    }

    private function form($url, $back_url, $data = null) {
      $user_id = _A_::$app->get('user_id');
      if(!isset($data)) {
        $data = Model_User::get_user_data($user_id);
      }
      $data['bill_list_countries'] = $this->list_countries($data['bill_country']);
      $data['ship_list_countries'] = $this->list_countries($data['ship_country']);
      $data['bill_list_province'] = $this->list_province($data['bill_country'], $data['bill_province']);
      $data['ship_list_province'] = $this->list_province($data['ship_country'], $data['ship_province']);

      $prms = null;
      if(!empty(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $back_url = _A_::$app->router()->UrlTo($back_url, $prms);
      $prms = null;
      if(!empty(_A_::$app->get('user_id'))) $prms['user_id'] = _A_::$app->get('user_id');
      $action = _A_::$app->router()->UrlTo($url, $prms);

      $this->template->vars('back_url', $back_url);
      $this->template->vars('data', $data);
      $this->template->vars('action', $action);
      $this->template->view_layout('form');
    }

    public function edit_add_handling($url, $back_url ,$title, $is_user = false, $outer_control = false) {
      $this->template->vars('form_title', $title);
      if(_A_::$app->request_is_post()) {
        $result = $this->save($data);
        if ($outer_control && $result) return $result;
        $this->form($url, $back_url, $data);
        exit;
      }
      if(!is_null(_A_::$app->get('method'))) {
        $this->form_handling();
        exit;
      }
      ob_start();
      $this->form($url, $back_url);
      $form = ob_get_contents();
      ob_end_clean();
      $this->template->vars('form', $form);
      if ($is_user) $this->main->view('edit');
      else $this->main->view_admin('edit');
      exit;
    }

    /**
     * @export
     */
    public function add() {
      $this->main->test_access_rights();
      $this->edit_add_handling('users/add', 'users', 'NEW USER');
    }

    /**
     * @export
     */
    public function edit() {
      $this->main->test_access_rights();
      $this->edit_add_handling('users/edit', 'users', 'EDIT USER');
    }

//    public function modify_accounts_password()
//    {
//        $per_page = 200;
//        $page = 1;
//        $total = Model_User::get_total_count_users();
//        $count = 0;
//        while ($page <= ceil($total / $per_page)) {
//            $start = (($page++ - 1) * $per_page);
//            $rows = Model_User::get_users_list($start, $per_page);
//            foreach ($rows as $row) {
//                $id = $row['aid'];
//                $current_password = $row['password'];
//                if (!strpos('$2a$12$', $current_password)) {
//                    $salt = Model_Auth::generatestr();
//                    $password = Model_Auth::hash_($current_password, $salt, 12);
//                    $check = Model_Auth::check($current_password, $password);
//                    if ($password == $check) Model_User::update_password($password, $id);
//                }
//            }
//            $count += count($rows);
//            echo $count;
//        }
//    }
  }