<?php

namespace controllers;

use app\core\App;
use classes\Auth;
use classes\controllers\ControllerFormSimple;
use classes\helpers\CaptchaHelper;
use classes\helpers\UserHelper;
use models\ModelAddress;
use models\ModelAuth;
use models\ModelUser;
use models\ModelUsers;

/**
 * Class ControllerUsers
 * @package controllers
 */
class ControllerUsers extends ControllerFormSimple{

  /**
   * @var string
   */
  protected $id_field = 'aid';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW USER';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY USER';
  /**
   * @var array
   */
  protected $resolved_scenario = ['', 'short', 'csv'];

  /**
   * @param null $select
   * @return string
   * @throws \Exception
   */
  private function list_countries($select = null){
    $countries = ModelAddress::get_countries_all();
    $this->main->view->setVars('items', $countries);
    $this->main->view->setVars('select', $select);

    return $this->RenderLayoutReturn('address/select_countries_options');
  }

  /**
   * @param $country
   * @param null $select
   * @return string
   * @throws \Exception
   */
  private function list_province($country, $select = null){
    $list = '';
    if(isset($country) && !empty($country)) {
      $provincies = ModelAddress::get_country_state($country);
      $this->main->view->setVars('items', $provincies);
      $this->main->view->setVars('select', $select);
      $list = $this->RenderLayoutReturn('address/select_countries_options');
    }

    return $list;
  }

  /**
   * @throws \Exception
   */
  protected function get_csv(){
    Auth::check_admin_authorized();
    $this->BuildOrder($sort);
    $filter = null;
    $csv_fields_dlm = !is_null(App::$app->keyStorage()->system_csv_fields_dlm) ?
      App::$app->keyStorage()->system_csv_fields_dlm : ',';
    $csv_fields = !is_null(App::$app->keyStorage()->system_csv_fields) ?
      App::$app->keyStorage()->system_csv_fields : CSV_FIELDS;
    if(!empty($csv_fields)) $csv_fields = explode($csv_fields_dlm, $csv_fields);
    if(!is_array($csv_fields) || (is_array($csv_fields) && (count($csv_fields) <= 0))) $csv_fields = [
      'email', 'bill_firstname', 'bill_lastname'
    ];
    $page = 1;
    $per_page = 1000;
    $total_rows = forward_static_call([$this->model, 'get_total_count']);
    $last_page = ceil($total_rows / $per_page);
    if($page > $last_page) $page = $last_page;
    if(ob_get_level()) {
      ob_end_clean();
    }
    header('Content-Description: File Transfer');
    $gz_use = !is_null(App::$app->keyStorage()->system_csv_use_gz) ?
      App::$app->keyStorage()->system_csv_use_gz : CSV_USE_GZ;
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
        $rows = forward_static_call_array([$this->model, 'get_list'], [
          $start, $per_page, &$res_count_rows, &$filter, &$sort
        ]);
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
        $rows = forward_static_call_array([$this->model, 'get_list'], [
          $start, $per_page, &$res_count_rows, &$filter, &$sort
        ]);
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

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    return [
      'aid', 'email', 'full_name', 'organization', 'address', 'province', 'city', 'country', 'postal', 'phone',
      'registered'
    ];
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function BuildOrder(&$sort, $view = false, $filter = null){
    parent::BuildOrder($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['full_name' => 'ASC'];
    }
  }

  /**
   * @param $id
   * @param $data
   * @throws \Exception
   */
  protected function after_save($id, &$data){
    if(isset($data['aid'])) {
      if(!is_null(App::$app->session('_')) && ($id == App::$app->session('_'))) {
        $user = ModelUsers::get_by_id($id);
        if(isset($user)) App::$app->setSession('user', $user);
      }
    } else {
      App::$app->get('aid', $id);
      $data = null;
    }
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    if($this->scenario() !== 'short') {
      $ship_as_billing = App::$app->post('ship_as_billing');
      $data = [
        'aid' => App::$app->get('aid'), 'email' => ModelUsers::sanitize(App::$app->post('email')),
        'bill_firstname' => ModelUsers::sanitize(App::$app->post('bill_firstname')),
        'bill_lastname' => ModelUsers::sanitize(App::$app->post('bill_lastname')),
        'bill_organization' => ModelUsers::sanitize(App::$app->post('bill_organization')),
        'bill_address1' => ModelUsers::sanitize(App::$app->post('bill_address1')),
        'bill_address2' => ModelUsers::sanitize(App::$app->post('bill_address2')),
        'bill_province' => ModelUsers::sanitize(App::$app->post('bill_province')),
        'bill_city' => ModelUsers::sanitize(App::$app->post('bill_city')),
        'bill_country' => ModelUsers::sanitize(App::$app->post('bill_country')),
        'bill_postal' => ModelUsers::sanitize(App::$app->post('bill_postal')),
        'bill_phone' => ModelUsers::sanitize(App::$app->post('bill_phone')),
        'bill_fax' => ModelUsers::sanitize(App::$app->post('bill_fax')),
        'bill_email' => ModelUsers::sanitize(App::$app->post('bill_email')),
        'ship_firstname' => ModelUsers::sanitize(App::$app->post('ship_firstname')),
        'ship_lastname' => ModelUsers::sanitize(App::$app->post('ship_lastname')),
        'ship_organization' => ModelUsers::sanitize(App::$app->post('ship_organization')),
        'ship_address1' => ModelUsers::sanitize(App::$app->post('ship_address1')),
        'ship_address2' => ModelUsers::sanitize(App::$app->post('ship_address2')),
        'ship_city' => ModelUsers::sanitize(App::$app->post('ship_city')),
        'ship_province' => ModelUsers::sanitize(App::$app->post('ship_province')),
        'ship_country' => ModelUsers::sanitize(App::$app->post('ship_country')),
        'ship_postal' => ModelUsers::sanitize(App::$app->post('ship_postal')),
        'ship_phone' => ModelUsers::sanitize(App::$app->post('ship_phone')),
        'ship_fax' => ModelUsers::sanitize(App::$app->post('ship_fax')),
        'ship_email' => ModelUsers::sanitize(App::$app->post('ship_email')),
      ];

      $data['create_password'] = ModelUser::sanitize(!is_null(App::$app->post('create_password')) ? App::$app->post('create_password') : '');
      $data['confirm_password'] = ModelUser::sanitize(!is_null(App::$app->post('confirm_password')) ? App::$app->post('confirm_password') : '');
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
        'aid' => App::$app->get('aid'), 'email' => ModelUsers::sanitize(App::$app->post('email')),
        'bill_firstname' => ModelUsers::sanitize(App::$app->post('bill_firstname')),
        'bill_lastname' => ModelUsers::sanitize(App::$app->post('bill_lastname')),
      ];

      $data['create_password'] = ModelUser::sanitize(!is_null(App::$app->post('create_password')) ? App::$app->post('create_password') : '');
      $data['confirm_password'] = ModelUser::sanitize(!is_null(App::$app->post('confirm_password')) ? App::$app->post('confirm_password') : '');
      $data['captcha'] = ModelUser::sanitize(!is_null(App::$app->post('captcha')) ? App::$app->post('captcha') : '');
    }
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   * @throws \ErrorException
   * @throws \Exception
   */
  protected function validate(&$data, &$error){

    if(empty($data['email'])) {
      $error = ["Email can't be blank!"];
    } else {
      if(ModelUser::exist($data['email'], $data['aid'])) {
        $error[] = 'User with such email already exists!';
      } else {
        if(($this->scenario() !== 'short') && (((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) || empty($data['bill_firstname']) || empty($data['bill_lastname']) || (empty($data['bill_address1']) && empty($data['bill_address2'])) || empty($data['bill_country']) || empty($data['bill_postal']) || empty($data['bill_phone']) || ((isset($data['ship_as_billing'])) && (empty($data['ship_firstname']) || empty($data['ship_lastname']) || (empty($data['ship_address1']) && empty($data['ship_address2'])) || empty($data['ship_country']) || empty($data['ship_postal']))))) {

          $error = ['Please fill in all required fields (marked with * )'];
          $error1 = [];
          $error2 = [];

          if((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) $error[] = '&#9;Identify <b>Create Password</b> and <b>Confirm Password</b> field!';
          if(empty($data['bill_firstname'])) $error1[] = '&#9;Identify <b>First Name</b> field!';
          if(empty($data['bill_lastname'])) $error1[] = '&#9;Identify <b>Last Name</b> field!';
          if((empty($data['bill_address1']) && empty($data['bill_address2']))) $error1[] = '&#9;Identify <b>Address</b> field!';
          if(empty($data['bill_country']{0})) $error1[] = '&#9;Identify <b>Country</b> field!';
          if(empty($data['bill_postal'])) $error1[] = '&#9;Identify <b>Postal/Zip Code</b> field!';
          if(empty($data['bill_phone'])) $error1[] = '&#9;Identify <b>Telephone</b> field!';
          if(count($error1) > 0) {
            if(count($error) > 0) $error[] = '<br>';
            $error[] = 'BILLING INFORMATION:';
            $error = array_merge($error, $error1);
          }
          if(isset($data['ship_as_billing'])) {

            if(empty($data['ship_firstname'])) $error2[] = '&#9;Identify <b>First Name</b> field!';
            if(empty($data['ship_lastname'])) $error2[] = '&#9;Identify <b>Last Name</b> field!';
            if((empty($data['ship_address1']) && empty($data['ship_address2']))) $error2[] = '&#9;Identify <b>Address</b> field!';
            if(empty($data['ship_country']{0})) $error2[] = '&#9;Identify <b>Country</b> field!';
            if(empty($data['ship_postal'])) $error2[] = '&#9;Identify <b>Postal/Zip Code</b> field!';

            if(count($error2) > 0) {
              if(count($error) > 0) $error[] = '';
              $error[] = 'SHIPPING INFORMATION:';
              $error = array_merge($error, $error2);
            }
          }
        } else {
          $verify = CaptchaHelper::check_captcha(isset($data['captcha']) ? $data['captcha'] : '', $error2);
          if(($this->scenario() == 'short') && (((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) || empty($data['bill_firstname']) || empty($data['bill_lastname']) || empty($data['captcha']) || !$verify)) {
            $error = ['Please fill in all required fields:'];
            $error1 = [];

            if((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) $error1[] = '&#9;Identify <b>Password</b> and <b>Confirm Password</b> field!';
            if(empty($data['bill_firstname'])) $error1[] = '&#9;Identify <b>First Name</b> field!';
            if(empty($data['bill_lastname'])) $error1[] = '&#9;Identify <b>Last Name</b> field!';
            if(empty($data['captcha'])) $error1[] = '&#9;Identify <b>Captcha</b> field!';
            if(!$verify) $error1[] = '&#9;' . $error2[0];
            if(count($error1) > 0) {
              if(count($error) > 0) $error[] = '';
              $error = array_merge($error, $error1);
            }
          } else {
            if(!empty($data['create_password'])) {
              $salt = ModelAuth::GenerateStr();
              $password = ModelAuth::getHash($data['create_password'], $salt, 12);
              $check = ModelAuth::check($data['confirm_password'], $password);
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

  /**
   * @param null $data
   * @return bool
   * @throws \Exception
   */
  protected function form_handling(&$data = null){
    if(App::$app->RequestIsPost() && (App::$app->post('method') == 'get_province_list'))
      exit($this->list_province(App::$app->post('country')));
    if(!empty($this->scenario())) {
      if($this->scenario() == 'csv') exit($this->get_csv());
    }

    return true;
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){
    if($this->scenario() !== 'short') {
      $data['bill_list_countries'] = $this->list_countries($data['bill_country']);
      $data['ship_list_countries'] = $this->list_countries($data['ship_country']);
      $data['bill_list_province'] = $this->list_province($data['bill_country'], $data['bill_province']);
      $data['ship_list_province'] = $this->list_province($data['ship_country'], $data['ship_province']);
    }
  }

  /**
   * @param $search_data
   * @param bool $view
   * @throws \Exception
   */
  protected function before_search_form_layout(&$search_data, $view = false){
    $countries = [];
    $rows = ModelAddress::get_countries_all();
    foreach($rows as $row) $countries[$row['id']] = $row['name'];
    $states = [];
    $rows = (isset($search_data['country'])) ? ModelAddress::get_country_state($search_data['country']) : ModelAddress::get_province_all();
    foreach($rows as $row) $states[$row['id']] = $row['name'];

    $search_data['countries'] = $countries;
    $search_data['states'] = $states;
  }

  /**
   * @param $data
   * @param $url
   * @param $back_url
   * @param $title
   * @param bool $is_user
   * @param bool $outer_control
   * @param null $scenario
   * @return bool
   * @throws \Exception
   */
  public function user_handling(&$data, $url, $back_url, $title, $is_user = false, $outer_control = false, $scenario = null){
    $this->scenario(!empty($scenario) ? $scenario : App::$app->get('method'));
    $this->main->view->setVars('form_title', $title);
    $this->load($data);
    if(App::$app->RequestIsPost() && $this->form_handling($data)) {
      $email = $data['email'];
      $result = $this->Save($data);
      if($outer_control && $result) {
        if($this->scenario() !== 'short') return $result; else {
          UserHelper::sendWelcomeEmail($email);
          $thanx = $this->RenderLayoutReturn('short/thanx');
          $this->main->view->setVars('warning', [$thanx]);

          return ($this->form($url, []));
        }
      }

      return ($this->form($url, $data));
    }
    $form = $this->form($url, null, true);
    if($this->scenario() == 'short') {

      return ($form);
    }
    $this->set_back_url($back_url);
    $this->main->view->setVars('form', $form);
    if($is_user) return ($this->render_view('edit'));
    else return ($this->render_view_admin('edit'));
  }

  /**
   * @export
   * @throws \Exception
   */
  public function users(){
    $this->form_handling();
    parent::index();
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }

  /**
   * @param bool $required_access
   */
  public function index($required_access = true){
  }

//    /**
//     * @export
//     */
//    public function modify_accounts_password() {
//      $per_page = 200;
//      $page = 1;
//      $total = ModelUsers::get_total_count();
//      $count = 0;
//      $res_count_rows = 0;
//      $filter = null;
//      $sort = null;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = ModelUsers::get_list($start, $per_page, $res_count_rows, $filter, $sort);
//        foreach($rows as $row) {
//          $id = $row['aid'];
//          $current_password = $row['password'];
//          if(!strpos('$2a$12$', $current_password)) {
//            $salt = ModelAuth::GenerateStr();
//            $password = ModelAuth::getHash($current_password, $salt, 12);
//            $check = ModelAuth::check($current_password, $password);
//            if($password == $check) ModelUser::update_password($password, $id);
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
//      $total = ModelAdmin::get_total_count();
//      $count = 0;
//      $res_count_rows = 0;
//      $filter = null;
//      $sort = null;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = ModelAdmin::get_list($start, $per_page, $res_count_rows, $filter, $sort);
//        foreach($rows as $row) {
//          $id = $row['id'];
//          $current_password = $row['password'];
//          if(!strpos('$2a$12$', $current_password)) {
//            $salt = ModelAuth::GenerateStr();
//            $password = ModelAuth::getHash($current_password, $salt, 12);
//            $check = ModelAuth::check($current_password, $password);
//            if($password == $check) ModelAdmin::update_password($password, $id);
//          }
//        }
//        $count += count($rows);
//        echo $count;
//      }
//    }

}