<?php

  class Controller_Users extends Controller_FormSimple {

    protected $id_field = 'aid';
    protected $form_title_add = 'NEW USER';
    protected $form_title_edit = 'MODIFY USER';
    protected $resolved_scenario = ['', 'short', 'csv'];

    private function list_countries($select = null) {
      $countries = Model_Address::get_countries_all();
      $this->template->vars('items', $countries);
      $this->template->vars('select', $select);
      return $this->template->view_layout_return('address/select_countries_options');
    }

    private function list_province($country, $select = null) {
      $list = '';
      if(isset($country) && !empty($country)) {
        $provincies = Model_Address::get_country_state($country);
        $this->template->vars('items', $provincies);
        $this->template->vars('select', $select);
        $list = $this->template->view_layout_return('address/select_countries_options');
      }
      return $list;
    }

    protected function get_csv() {
      $this->main->is_admin_authorized();
      $this->build_order($sort);
      $filter = null;
      $csv_fields_dlm = (!is_null(_A_::$app->keyStorage()->system_csv_fields_dlm) ? _A_::$app->keyStorage()->system_csv_fields_dlm : ',');
      $csv_fields = (!is_null(_A_::$app->keyStorage()->system_csv_fields) ? _A_::$app->keyStorage()->system_csv_fields : CSV_FIELDS);
      if(!empty($csv_fields)) $csv_fields = explode($csv_fields_dlm, $csv_fields);
      if(!is_array($csv_fields) || (is_array($csv_fields) && (count($csv_fields) <= 0))) $csv_fields = ['email', 'bill_firstname', 'bill_lastname'];
      $page = 1;
      $per_page = 1000;
      $total_rows = forward_static_call([$this->model_name, 'get_total_count']);
      $last_page = ceil($total_rows / $per_page);
      if($page > $last_page) $page = $last_page;
      if(ob_get_level()) {
        ob_end_clean();
      }
      header('Content-Description: File Transfer');
      $gz_use = (!is_null(_A_::$app->keyStorage()->system_csv_use_gz) ? _A_::$app->keyStorage()->system_csv_use_gz : CSV_USE_GZ);
      if(function_exists('gzopen') && ($gz_use == '1')) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="users.csv.gz"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Expires: 0');
        header('Pragma: public');
        $filename = sys_get_temp_dir() . DS . 'gz_' . uniqid();
        $csv = gzopen($filename, 'w');
        gzwrite($csv, implode($csv_fields_dlm, $csv_fields) . "\r\n");
        while($page <= $last_page) {
          $start = (($page - 1) * $per_page);
          $res_count_rows = 0;
          $rows = forward_static_call_array([$this->model_name, 'get_list'], [$start, $per_page, &$res_count_rows, &$filter, &$sort]);
          if($res_count_rows > 0):
            foreach($rows as $row):
              $csv_row = '';
              foreach($csv_fields as $field) {
                if(isset($row[$field])) {
                  $csv_row .= str_replace($csv_fields_dlm, '_', $row[$field]) . $csv_fields_dlm;
                }
              }
              $csv_row = substr($csv_row, 0, -1) . "\r\n";
              if(!empty($csv_row)) gzwrite($csv, $csv_row);
            endforeach;
          endif;
          $page += 1;
        }
        gzclose($csv);
        $size = filesize($filename);
        header('Content-Length: ' . $size);
        $csv = fopen($filename, 'rb');
        while(!feof($csv)) {
          echo fread($csv, 4096);
        }
        fclose($csv);
        unlink($filename);
      } else {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="users.csv"');
        header('Cache-Control: must-revalidate');
        header('Expires: 0');
        header('Pragma: public');
        echo implode($csv_fields_dlm, $csv_fields) . "\r\n";
        while($page <= $last_page) {
          $start = (($page - 1) * $per_page);
          $res_count_rows = 0;
          $rows = forward_static_call_array([$this->model_name, 'get_list'], [$start, $per_page, &$res_count_rows, &$filter, &$sort]);
          if($res_count_rows > 0):
            foreach($rows as $row):
              $csv_row = '';
              foreach($csv_fields as $field) {
                if(isset($row[$field])) {
                  $csv_row .= str_replace($csv_fields_dlm, '_', $row[$field]) . $csv_fields_dlm;
                }
              }
              $csv_row = rtrim($csv_row, ',') . "\r\n";
              if(!empty($csv_row)) echo $csv_row;
            endforeach;
          endif;
          $page += 1;
        }
      }
    }

    protected function search_fields($view = false) {
      return [
        'aid', 'email', 'full_name',
        'organization', 'address',
        'province', 'city', 'country',
        'postal', 'phone', 'registered'
      ];
    }

    protected function build_order(&$sort, $view = false, $filter = null) {
      parent::build_order($sort, $view, $filter);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['full_name' => 'ASC'];
      }
    }

    protected function after_save($id, &$data) {
      if(isset($data['aid'])) {
        if(!is_null(_A_::$app->session('_')) && ($id == _A_::$app->session('_'))) {
          $user = Model_Users::get_by_id($id);
          if(isset($user)) _A_::$app->setSession('user', $user);
        }
      } else {
        _A_::$app->get('aid', $id);
        $data = null;
      }
    }

    protected function load(&$data) {
      if($this->scenario() !== 'short') {
        $ship_as_billing = _A_::$app->post('ship_as_billing');
        $data = [
          'aid' => _A_::$app->get('aid'),
          'email' => Model_Users::sanitize(_A_::$app->post('email')),
          'bill_firstname' => Model_Users::sanitize(_A_::$app->post('bill_firstname')),
          'bill_lastname' => Model_Users::sanitize(_A_::$app->post('bill_lastname')),
          'bill_organization' => Model_Users::sanitize(_A_::$app->post('bill_organization')),
          'bill_address1' => Model_Users::sanitize(_A_::$app->post('bill_address1')),
          'bill_address2' => Model_Users::sanitize(_A_::$app->post('bill_address2')),
          'bill_province' => Model_Users::sanitize(_A_::$app->post('bill_province')),
          'bill_city' => Model_Users::sanitize(_A_::$app->post('bill_city')),
          'bill_country' => Model_Users::sanitize(_A_::$app->post('bill_country')),
          'bill_postal' => Model_Users::sanitize(_A_::$app->post('bill_postal')),
          'bill_phone' => Model_Users::sanitize(_A_::$app->post('bill_phone')),
          'bill_fax' => Model_Users::sanitize(_A_::$app->post('bill_fax')),
          'bill_email' => Model_Users::sanitize(_A_::$app->post('bill_email')),
          'ship_firstname' => Model_Users::sanitize(_A_::$app->post('ship_firstname')),
          'ship_lastname' => Model_Users::sanitize(_A_::$app->post('ship_lastname')),
          'ship_organization' => Model_Users::sanitize(_A_::$app->post('ship_organization')),
          'ship_address1' => Model_Users::sanitize(_A_::$app->post('ship_address1')),
          'ship_address2' => Model_Users::sanitize(_A_::$app->post('ship_address2')),
          'ship_city' => Model_Users::sanitize(_A_::$app->post('ship_city')),
          'ship_province' => Model_Users::sanitize(_A_::$app->post('ship_province')),
          'ship_country' => Model_Users::sanitize(_A_::$app->post('ship_country')),
          'ship_postal' => Model_Users::sanitize(_A_::$app->post('ship_postal')),
          'ship_phone' => Model_Users::sanitize(_A_::$app->post('ship_phone')),
          'ship_fax' => Model_Users::sanitize(_A_::$app->post('ship_fax')),
          'ship_email' => Model_Users::sanitize(_A_::$app->post('ship_email')),
        ];

        $data['create_password'] = Model_User::sanitize(!is_null(_A_::$app->post('create_password')) ? _A_::$app->post('create_password') : '');
        $data['confirm_password'] = Model_User::sanitize(!is_null(_A_::$app->post('confirm_password')) ? _A_::$app->post('confirm_password') : '');
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
      } else {
        $data = [
          'aid' => _A_::$app->get('aid'),
          'email' => Model_Users::sanitize(_A_::$app->post('email')),
          'bill_firstname' => Model_Users::sanitize(_A_::$app->post('bill_firstname')),
          'bill_lastname' => Model_Users::sanitize(_A_::$app->post('bill_lastname')),
        ];

        $data['create_password'] = Model_User::sanitize(!is_null(_A_::$app->post('create_password')) ? _A_::$app->post('create_password') : '');
        $data['confirm_password'] = Model_User::sanitize(!is_null(_A_::$app->post('confirm_password')) ? _A_::$app->post('confirm_password') : '');
        $data['captcha'] = Model_User::sanitize(!is_null(_A_::$app->post('captcha')) ? _A_::$app->post('captcha') : '');
      }
    }

    protected function validate(&$data, &$error) {

      if(empty($data['email'])) {
        $error = ["Email can't be blank!"];
      } else {
        if(Model_User::exist($data['email'], $data['aid'])) {
          $error[] = 'User with such email already exists!';
        } else {
          if(($this->scenario() !== 'short') && (
              ((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) ||
              empty($data['bill_firstname']) ||
              empty($data['bill_lastname']) ||
              (empty($data['bill_address1']) && empty($data['bill_address2'])) ||
              empty($data['bill_country']) ||
              empty($data['bill_postal']) ||
              empty($data['bill_phone']) ||
              ((isset($data['ship_as_billing'])) &&
                (empty($data['ship_firstname']) ||
                  empty($data['ship_lastname']) ||
                  (empty($data['ship_address1']) && empty($data['ship_address2'])) ||
                  empty($data['ship_country']) || empty($data['ship_postal']))))
          ) {

            $error = ['Please fill in all required fields (marked with * )'];
            $error1 = [];
            $error2 = [];

            if((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password'])))
              $error[] = '&#9;Identify <b>Create Password</b> and <b>Confirm Password</b> field!';
            if(empty($data['bill_firstname']))
              $error1[] = '&#9;Identify <b>First Name</b> field!';
            if(empty($data['bill_lastname']))
              $error1[] = '&#9;Identify <b>Last Name</b> field!';
            if((empty($data['bill_address1']) && empty($data['bill_address2'])))
              $error1[] = '&#9;Identify <b>Address</b> field!';
            if(empty($data['bill_country']{0}))
              $error1[] = '&#9;Identify <b>Country</b> field!';
            if(empty($data['bill_postal']))
              $error1[] = '&#9;Identify <b>Postal/Zip Code</b> field!';
            if(empty($data['bill_phone']))
              $error1[] = '&#9;Identify <b>Telephone</b> field!';
            if(count($error1) > 0) {
              if(count($error) > 0) $error[] = '<br>';
              $error[] = 'BILLING INFORMATION:';
              $error = array_merge($error, $error1);
            }
            if(isset($data['ship_as_billing'])) {

              if(empty($data['ship_firstname']))
                $error2[] = '&#9;Identify <b>First Name</b> field!';
              if(empty($data['ship_lastname']))
                $error2[] = '&#9;Identify <b>Last Name</b> field!';
              if((empty($data['ship_address1']) && empty($data['ship_address2'])))
                $error2[] = '&#9;Identify <b>Address</b> field!';
              if(empty($data['ship_country']{0}))
                $error2[] = '&#9;Identify <b>Country</b> field!';
              if(empty($data['ship_postal']))
                $error2[] = '&#9;Identify <b>Postal/Zip Code</b> field!';

              if(count($error2) > 0) {
                if(count($error) > 0)
                  $error[] = '';
                $error[] = 'SHIPPING INFORMATION:';
                $error = array_merge($error, $error2);
              }
            }
          } else {
            $verify = Controller_Captcha::check_captcha(isset($data['captcha']) ? $data['captcha'] : '', $error2);
            if(($this->scenario() == 'short') && (
                ((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) ||
                empty($data['bill_firstname']) ||
                empty($data['bill_lastname']) ||
                empty($data['captcha']) || !$verify
              )
            ) {
              $error = ['Please fill in all required fields:'];
              $error1 = [];

              if((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password'])))
                $error1[] = '&#9;Identify <b>Password</b> and <b>Confirm Password</b> field!';
              if(empty($data['bill_firstname']))
                $error1[] = '&#9;Identify <b>First Name</b> field!';
              if(empty($data['bill_lastname']))
                $error1[] = '&#9;Identify <b>Last Name</b> field!';
              if(empty($data['captcha']))
                $error1[] = '&#9;Identify <b>Captcha</b> field!';
              if(!$verify)
                $error1[] = '&#9;' . $error2[0];
              if(count($error1) > 0) {
                if(count($error) > 0) $error[] = '';
                $error = array_merge($error, $error1);
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
                $error[] = 'Confirm password doesn\'t match';
              }
            }
          }
        }
      }
      return false;
    }

    protected function form_handling(&$data = null) {
      if(_A_::$app->request_is_post() && (_A_::$app->post('method') == 'get_province_list')) exit($this->list_province(_A_::$app->post('country')));
      if(!empty($this->scenario())) {
        if($this->scenario() == 'csv') exit($this->get_csv());
      }
      return true;
    }

    protected function before_form_layout(&$data = null) {
      if($this->scenario() !== 'short') {
        $data['bill_list_countries'] = $this->list_countries($data['bill_country']);
        $data['ship_list_countries'] = $this->list_countries($data['ship_country']);
        $data['bill_list_province'] = $this->list_province($data['bill_country'], $data['bill_province']);
        $data['ship_list_province'] = $this->list_province($data['ship_country'], $data['ship_province']);
      }
    }

    protected function before_search_form_layout(&$search_data, $view = false) {
      $countries = [];
      $rows = Model_Address::get_countries_all();
      foreach($rows as $row) $countries[$row['id']] = $row['name'];
      $states = [];
      $rows = (isset($search_data['country'])) ? Model_Address::get_country_state($search_data['country']) : Model_Address::get_province_all();
      foreach($rows as $row) $states[$row['id']] = $row['name'];

      $search_data['countries'] = $countries;
      $search_data['states'] = $states;
    }

    public function user_handling(&$data, $url, $back_url, $title, $is_user = false, $outer_control = false) {
      $this->scenario(_A_::$app->get('method'));
      $this->template->vars('form_title', $title);
      $this->load($data);
      if(_A_::$app->request_is_post() && $this->form_handling($data)) {
        $result = $this->save($data);
        if($outer_control && $result) {
          if($this->scenario() !== 'short') return $result;
          else {
            Controller_User::sendWelcomeEmail($data['email']);
            $thanx = $this->template->view_layout_return('short/thanx');
            $this->template->vars('warning', [$thanx]);
            exit($this->form($url, []));
          }
        }
        exit($this->form($url, $data));
      }
      $form = $this->form($url, null, true);
      if($this->scenario() == 'short') exit($form);
      $this->set_back_url($back_url);
      $this->template->vars('form', $form);
      if($is_user) exit($this->main->view('edit'));
      else exit($this->main->view_admin('edit'));
    }

    /**
     * @export
     */
    public function users() {
      $this->form_handling();
      parent::index();
    }

    public function view($partial = false, $required_access = false) { }

    public function index($required_access = true) { }

//    /**
//     * @export
//     */
//    public function modify_accounts_password() {
//      $per_page = 200;
//      $page = 1;
//      $total = Model_Users::get_total_count();
//      $count = 0;
//      $res_count_rows = 0;
//      $filter = null;
//      $sort = null;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = Model_Users::get_list($start, $per_page, $res_count_rows, $filter, $sort);
//        foreach($rows as $row) {
//          $id = $row['aid'];
//          $current_password = $row['password'];
//          if(!strpos('$2a$12$', $current_password)) {
//            $salt = Model_Auth::generatestr();
//            $password = Model_Auth::hash_($current_password, $salt, 12);
//            $check = Model_Auth::check($current_password, $password);
//            if($password == $check) Model_User::update_password($password, $id);
//          }
//        }
//        $count += count($rows);
//        echo $count;
//      }
//    }

//    /**
//     * @export
//     */
//    public function modify_admins_password() {
//      $per_page = 200;
//      $page = 1;
//      $total = Model_Admin::get_total_count();
//      $count = 0;
//      $res_count_rows = 0;
//      $filter = null;
//      $sort = null;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = Model_Admin::get_list($start, $per_page, $res_count_rows, $filter, $sort);
//        foreach($rows as $row) {
//          $id = $row['id'];
//          $current_password = $row['password'];
//          if(!strpos('$2a$12$', $current_password)) {
//            $salt = Model_Auth::generatestr();
//            $password = Model_Auth::hash_($current_password, $salt, 12);
//            $check = Model_Auth::check($current_password, $password);
//            if($password == $check) Model_Admin::update_password($password, $id);
//          }
//        }
//        $count += count($rows);
//        echo $count;
//      }
//    }

  }