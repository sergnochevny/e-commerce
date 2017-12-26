<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerSimple;
use models\ModelBlogCategory;

/**
 * Class ControllerBlogCategory
 * @package controllers
 */
class ControllerBlogCategory extends ControllerSimple{

  protected $id_field = 'id';
  protected $form_title_add = 'ADD NEW CATEGORY';
  protected $form_title_edit = 'EDIT CATEGORY';

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.name' => 'desc'];
    }
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data = [
      $this->id_field => App::$app->get($this->id_field),
      'name' => ModelBlogCategory::sanitize(App::$app->post('name')),
    ];
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    $error = null;
    if(empty($data['name'])) {
      $error[] = "The Category Name is required.";

      return false;
    }

    return true;
  }

}