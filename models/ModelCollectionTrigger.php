<?php

namespace models;

use app\core\model\ModelSimple;

/**
 * Class ModelCollectionTrigger
 * @package console\models
 */
class ModelCollectionTrigger extends ModelSimple{

  /**
   * @var string
   */
  protected static $table = 'collection_trigger';

  /**
   * @throws \Exception
   */
  public static function setTriggers(){
    try {
      static::Save(['type' => 1, 'trigger' => 1]);
      static::Save(['type' => 2, 'trigger' => 1]);
      static::Save(['type' => 3, 'trigger' => 1]);
    } catch(\Exception $e) {
    }
  }

}