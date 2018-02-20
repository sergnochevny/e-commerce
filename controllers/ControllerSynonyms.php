<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerSimple;
use models\ModelSynonyms;

/**
 * Class ControllerSynonyms
 * @package controllers
 */
class ControllerSynonyms extends ControllerSimple{

  /**
   * @var string
   */
  protected $id_field = 'id';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW SYNONYMS';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY SYNONYMS';

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['keywords' => 'asc'];
    }
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data = [
      $this->id_field => App::$app->get($this->id_field),
      'keywords' => trim(ModelSynonyms::sanitize(App::$app->post('keywords'))),
      'synonyms' => trim(ModelSynonyms::sanitize(App::$app->post('synonyms')))
    ];
  }

  /**
   * @param $data
   */
  protected function before_save(&$data){
    $data['keywords'] = preg_replace("/\r\n/i", ",", $data['keywords']);
    $data['synonyms'] = preg_replace("/\r\n/i", ",", $data['synonyms']);
    $data['keywords'] = preg_replace("/\r/i", ",", $data['keywords']);
    $data['synonyms'] = preg_replace("/\r/i", ",", $data['synonyms']);
    $data['keywords'] = preg_replace("/\n/i", ",", $data['keywords']);
    $data['synonyms'] = preg_replace("/\n/i", ",", $data['synonyms']);
    $data['keywords'] = implode(',', array_filter(array_map('trim', explode(',', $data['keywords']))));
    $data['synonyms'] = implode(',', array_filter(array_map('trim', explode(',', $data['synonyms']))));
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    $error = null;
    if(empty($data['keywords']) || empty($data['synonyms'])) {
      $error = [];
      if(empty($data['keywords'])) $error[] = "Keywords is required.";
      if(empty($data['synonyms'])) $error[] = "Synonyms is required.";

      return false;
    }

    return true;
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }

}