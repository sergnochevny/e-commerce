<?php

  class Controller_Users extends Controller_Formsimple {

    protected $id_name = 'aid';
    protected $form_title_add = 'NEW USER';
    protected $form_title_edit = 'MODIFY USER';

    private function list_countries($select = null) {
      $countries = Model_Address::get_countries_all();
      $this->template->vars('items', $countries);
      $this->template->vars('select', $select);
      ob_start();
      $this->template->view_layout('address/select_countries_options');
      $list = ob_get_contents();
      ob_end_clean();
      return $list;
    }

    private function get_province_list() {
      echo $this->list_province(_A_::$app->get('country'));
    }

    private function list_province($country, $select = null) {
      $list = '';
      if(isset($country) && !empty($country)) {
        $provincies = Model_Address::get_country_state($country);
        $this->template->vars('items', $provincies);
        $this->template->vars('select', $select);
        ob_start();
        $this->template->view_layout('address/select_countries_options');
        $list = ob_get_contents();
        ob_end_clean();
      }
      return $list;
    }

    protected function save(&$data) {
      $result = false;
      $error = $data = null;
      if($this->load($data, $error)) {
        try {
          $aid = Model_Users::save($data);
          if(isset($data['aid'])) {
            if(!is_null(_A_::$app->session('_')) && ($aid == _A_::$app->session('_'))) {
              $user = Model_Users::get_by_id($aid);
              if(isset($user)) _A_::$app->setSession('user', $user);
            }
          } else {
            _A_::$app->get('aid', $aid);
            $data = null;
          }
          $warning = ['All data saved successfully!!!'];
          $result = true;
        } catch(Exception $e) {
          $error[] = $e->getMessage();
        }
      }

      if(isset($warning)) $this->template->vars('warning', $warning);
      if(isset($error)) $this->template->vars('error', $error);

      return $result;
    }

    protected function load(&$data, &$error) {

      $ship_as_billing = _A_::$app->post('ship_as_billing');
      $data = [
        'aid' => _A_::$app->get('aid'),
        'email' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('email'))),
        'bill_firstname' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_firstname'))),
        'bill_lastname' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_lastname'))),
        'bill_organization' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_organization'))),
        'bill_address1' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_address1'))),
        'bill_address2' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_address2'))),
        'bill_province' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_province'))),
        'bill_city' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_city'))),
        'bill_country' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_country'))),
        'bill_postal' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_postal'))),
        'bill_phone' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_phone'))),
        'bill_fax' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_fax'))),
        'bill_email' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('bill_email'))),
        'ship_firstname' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_firstname'))),
        'ship_lastname' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_lastname'))),
        'ship_organization' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_organization'))),
        'ship_address1' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_address1'))),
        'ship_address2' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_address2'))),
        'ship_city' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_city'))),
        'ship_province' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_province'))),
        'ship_country' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_country'))),
        'ship_postal' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_postal'))),
        'ship_phone' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_phone'))),
        'ship_fax' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_fax'))),
        'ship_email' => mysql_real_escape_string(Model_User::validData(_A_::$app->post('ship_email'))),
      ];

      $data['create_password'] = Model_User::validData(!is_null(_A_::$app->post('create_password')) ? _A_::$app->post('create_password') : '');
      $data['confirm_password'] = Model_User::validData(!is_null(_A_::$app->post('confirm_password')) ? _A_::$app->post('confirm_password') : '');
      $data['ship_as_billing'] = $ship_as_billing;
      if($ship_as_billing == 1) {
        $data['ship_firstname'] = $data['bill_firstname'];
        $data['ship_lastname'] = $data['bill_lastname'];
        $data['ship_organization'] = $data['bill_organization'];
        $data['ship_address1'] = $data['bill_address1'];
        $data['ship_address2'] = $data['bill_address2'];
        $data['ship_city'] = $data['bill_city'];
        $data['ship_province'] = $data['bill_province'];
        $data['ship_country'] = $data['bill_country'];
        $data['ship_postal'] = $data['bill_postal'];
        $data['ship_phone'] = $data['bill_phone'];
        $data['ship_fax'] = $data['bill_fax'];
        $data['ship_email'] = $data['bill_email'];
      }

      if(empty($data['email'])) {
        $error = ['Identify email field!!!'];
      } else {
        if(Model_User::exist($data['email'], $data['aid'])) {
          $error[] = 'User with this email already exists!!!';
        } else {
          if(
            ((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) ||
            empty($data['bill_firstname']) ||
            empty($data['bill_lastname']) ||
            (empty($data['bill_address1']) && empty($data['bill_address2'])) ||
            empty($data['bill_country']) ||
            empty($data['bill_postal']) ||
            empty($data['bill_phone']) ||
            ((is_null($ship_as_billing)) &&
              (empty($data['ship_firstname']) ||
                empty($data['ship_lastname']) ||
                (empty($data['ship_address1']) && empty($data['ship_address2'])) ||
                empty($data['ship_country']) || empty($data['ship_postal'])))
          ) {

            $error = ['Please fill in all required fields (marked with * )'];
            $error1 = [];
            $error2 = [];

            if((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password'])))
              $error[] = '<pre>&#9;Identify <b>Create Password</b> and <b>Confirm Password</b> field!!!</pre>';
            if(empty($data['bill_firstname']))
              $error1[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
            if(empty($data['bill_lastname']))
              $error1[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
            if((empty($data['bill_address1']) && empty($data['bill_address2'])))
              $error1[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
            if(empty($data['bill_country']{0}))
              $error1[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
            if(empty($data['bill_postal']))
              $error1[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';
            if(empty($data['bill_phone']))
              $error1[] = '<pre>&#9;Identify <b>Telephone</b> field!!!</pre>';
            if(count($error1) > 0) {
              if(count($error) > 0) $error[] = '<br>';
              $error[] = 'BILLING INFORMATION:';
              $error = array_merge($error, $error1);
            }
            if(is_null($ship_as_billing)) {

              if(empty($data['ship_firstname']))
                $error2[] = '<pre>&#9;Identify <b>First Name</b> field!!!</pre>';
              if(empty($data['ship_lastname']))
                $error2[] = '<pre>&#9;Identify <b>Last Name</b> field!!!</pre>';
              if((empty($data['ship_address1']) && empty($data['ship_address2'])))
                $error2[] = '<pre>&#9;Identify <b>Address</b> field!!!</pre>';
              if(empty($data['ship_country']{0}))
                $error2[] = '<pre>&#9;Identify <b>Country</b> field!!!</pre>';
              if(empty($data['ship_postal']))
                $error2[] = '<pre>&#9;Identify <b>Postal/Zip Code</b> field!!!</pre>';

              if(count($error2) > 0) {
                if(count($error) > 0)
                  $error[] = '';
                $error[] = 'SHIPPING INFORMATION:';
                $error = array_merge($error, $error2);
              }
            }
          } else {
            if(!empty($data['create_password'])) {
              $salt = Model_Auth::generatestr();
              $password = Model_Auth::hash_($data['create_password'], $salt, 12);
              $check = Model_Auth::check($data['confirm_password'], $password);
            } else $password = null;

            if(is_null($password) || (isset($check) && ($password == $check))) {
              $data['password'] = $password;
              return true;
            } else {
              $error[] = 'Password and Confirm Password must be identical!!!';
            }
          }
        }
      }
      return false;
    }

    protected function form_handling(&$data = null) {
      if(!is_null(_A_::$app->get('method'))) {
        $method = _A_::$app->get('method');
        if($method == 'get_province_list') {
          exit($this->get_province_list());
        }
      }
      return true;
    }

    protected function form_after_get_data(&$data = null) {
      $data['bill_list_countries'] = $this->list_countries($data['bill_country']);
      $data['ship_list_countries'] = $this->list_countries($data['ship_country']);
      $data['bill_list_province'] = $this->list_province($data['bill_country'], $data['bill_province']);
      $data['ship_list_province'] = $this->list_province($data['ship_country'], $data['ship_province']);
    }

    public function user_handling(&$data, $url, $back_url, $title, $is_user = false, $outer_control = false) {
      $this->template->vars('form_title', $title);
      if($this->form_handling() && _A_::$app->request_is_post()) {
        $result = $this->save($data);
        if($outer_control && $result) return $result;
        exit($this->form($url, $data));
      }
      ob_start();
        $this->form($url);
        $form = ob_get_contents();
      ob_end_clean();
      $prms = null;
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $back_url = _A_::$app->router()->UrlTo($back_url, $prms);
      $this->template->vars('back_url', $back_url);
      $this->template->vars('form', $form);
      if($is_user) $this->main->view('edit');
      else $this->main->view_admin('edit');
    }

//    public function modify_accounts_password()
//    {
//        $per_page = 200;
//        $page = 1;
//        $total = Model_User::get_total_count_users();
//        $count = 0;
//        while ($page <= ceil($total / $per_page)) {
//            $start = (($page++ - 1) * $per_page);
//            $rows = Model_Users::get_list($start, $per_page);
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