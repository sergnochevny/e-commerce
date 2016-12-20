<?php

  class Controller_Synonyms extends Controller_Simple {

    protected $id_name = 'id';
    protected $form_title_add = 'NEW SYNONYMS';
    protected $form_title_edit = 'MODIFY SYNONYMS';

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['keywords' => 'asc'];
      }
    }

    protected function load(&$data) {
      $data = [
        $this->id_name => _A_::$app->get($this->id_name),
        'keywords' => trim(Model_Synonyms::sanitize(_A_::$app->post('keywords'))),
        'synonyms' => trim(Model_Synonyms::sanitize(_A_::$app->post('synonyms')))
      ];
    }

    protected function before_save(&$data) {
      $data['keywords'] = preg_replace("/\r\n/i", ",", $data['keywords']);
      $data['synonyms'] = preg_replace("/\r\n/i", ",", $data['synonyms']);
      $data['keywords'] = preg_replace("/\r/i", ",", $data['keywords']);
      $data['synonyms'] = preg_replace("/\r/i", ",", $data['synonyms']);
      $data['keywords'] = preg_replace("/\n/i", ",", $data['keywords']);
      $data['synonyms'] = preg_replace("/\n/i", ",", $data['synonyms']);
      $data['keywords'] = mysql_real_escape_string(implode(',', array_filter(array_map('trim', explode(',', $data['keywords'])))));
      $data['synonyms'] = mysql_real_escape_string(implode(',', array_filter(array_map('trim', explode(',', $data['synonyms'])))));
    }

    protected function validate(&$data, &$error) {
      $error = null;
      if(empty($data['keywords']) || empty($data['synonyms'])) {
        $error = [];
        if(empty($data['keywords'])) $error[] = "Keywords is required.";
        if(empty($data['synonyms'])) $error[] = "Synonyms is required.";
        return false;
      }
      return true;
    }

    public function view() { }

  }