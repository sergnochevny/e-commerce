<?php

  class Controller_Settings extends Controller_FormSimple {

    protected $form_title_edit = 'MODIFY SETTINGS';

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

    public function view() { }

    public function delete($required_access = true) { }

    public function index($required_access = true) { }

    public function add($required_access = true) { }

  }