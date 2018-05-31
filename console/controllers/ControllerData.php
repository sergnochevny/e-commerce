<?php

namespace console\controllers;

use app\core\console\Console;
use app\core\console\controller\ControllerBase;
use app\core\console\model\ModelConsole;
use console\models\ModelCollection;
use console\models\ModelCollectionTrigger;
use console\models\ModelShop;
use Exception;

class ControllerData extends ControllerBase{

  /**
   * @throws \Exception
   */
  protected function collect_under(){
    ModelConsole::BeginTransaction();
    try {
      $limit = Console::$app->KeyStorage()->shop_under_limit;
      $trigger = ModelCollectionTrigger::getOne([
        'fields' => [
          'type' => [
            'not' => false, 'condition' => '=', 'value' => 3
          ]
        ]
      ]);
      if(!empty($trigger) && ($trigger['trigger'] == 1)) {
        ModelCollectionTrigger::Save(['type' => 3, 'trigger' => 0]);
        ModelCollection::delete(['fields' => ['type' => ['not' => false, 'condition' => '=', 'value' => 3]]]);
        $start = 0;
        $terminate = false;
        do {
          $rows = ModelShop::getWidgetListByType('under', $start, $limit, $row_count);
          if(!empty($rows) && (count($rows) > 0)) {
            foreach($rows as $row) {
              if($row['saleprice'] <= 100) {
                ModelCollection::Save(['type' => 3, 'pid' => $row['pid'], 'price' => $row['saleprice']]);
              }
            }
            $start += $limit;
          } else $terminate = true;
        } while(!$terminate);
      }
      ModelConsole::Commit();
    } catch(Exception $e) {
      ModelConsole::RollBack();
      throw $e;
    }
  }

  /**
   * @throws \Exception
   */
  protected function collect_specials(){
    ModelConsole::BeginTransaction();
    try {
      $select_type = ['specials_1', 'specials_2'];
      $specials = [];
      $limit = (int)Console::$app->KeyStorage()->shop_specials_limit;
      $terminate_limit = (int)Console::$app->KeyStorage()->shop_specials_amount;
      $trigger = ModelCollectionTrigger::getOne([
        'fields' => [
          'type' => [
            'not' => false, 'condition' => '=', 'value' => 2
          ]
        ]
      ]);
      if(!empty($trigger) && ($trigger['trigger'] == 1)) {
        ModelCollectionTrigger::Save(['type' => 2, 'trigger' => 0]);
        ModelCollection::delete(['fields' => ['type' => ['not' => false, 'condition' => '=', 'value' => 2]]]);
        foreach($select_type as $type) {
          $start = 0;
          $tmp = [];
          $terminate = false;
          do {
            $rows = ModelShop::getWidgetListByType($type, $start, $limit, $row_count);
            if(!empty($rows) && (count($rows) > 0)) {
              foreach($rows as $row) {
                if($terminate) break;
                switch($type) {
                  case 'specials_1':
                    $tmp[] = $row;
                    break;
                  case 'specials_2':
                    if($row['discount']) $tmp[] = $row;
                    break;
                }
                if(count($tmp) >= $terminate_limit) $terminate = true;
              }
              $start += $limit;
            } else $terminate = true;
          } while(!$terminate);
          $specials = array_merge($specials, $tmp);
        }
        if(!empty($specials) && (count($specials) > 0)) {
          shuffle($specials);
          foreach($specials as $row) {
            ModelCollection::Save(['type' => 2, 'pid' => $row['pid'], 'price' => $row['saleprice']]);
            if($terminate_limit-- <= 0) break;
          }
        }
      }
      ModelConsole::Commit();
    } catch(Exception $e) {
      ModelConsole::RollBack();
      throw $e;
    }
  }

  /**
   * @throws \Exception
   */
  protected function collect_bestsellers(){
    ModelConsole::BeginTransaction();
    try {
      $select_type = ['bestsellers_1', 'bestsellers_2'];
      $specials = [];
      $limit = (int)Console::$app->KeyStorage()->shop_bestsellers_limit;
      $terminate_limit = (int)Console::$app->KeyStorage()->shop_bestsellers_amount;
      $trigger = ModelCollectionTrigger::getOne([
        'fields' => [
          'type' => [
            'not' => false, 'condition' => '=', 'value' => 1
          ]
        ]
      ]);
      if(!empty($trigger) && ($trigger['trigger'] == 1)) {
        ModelCollectionTrigger::Save(['type' => 1, 'trigger' => 0]);
        ModelCollection::Delete(['fields' => ['type' => ['not' => false, 'condition' => '=', 'value' => 1]]]);
        foreach($select_type as $type) {
          $start = 0;
          $tmp = [];
          $terminate = false;
          do {
            $rows = ModelShop::getWidgetListByType($type, $start, $limit, $row_count);
            if(!empty($rows) && (count($rows) > 0)) {
              foreach($rows as $row) {
                if($terminate) break;
                switch($type) {
                  case 'bestsellers_1':
                    $tmp[] = $row;
                    break;
                  case 'bestsellers_2':
                    if($row['discount']) $tmp[] = $row;
                    break;
                }
                if(count($tmp) >= $terminate_limit) $terminate = true;
              }
              $start += $limit;
            } else $terminate = true;
          } while(!$terminate);
          $specials = array_merge($specials, $tmp);
        }
        if(!empty($specials) && (count($specials) > 0)) {
          shuffle($specials);
          foreach($specials as $row) {
            ModelCollection::Save(['type' => 1, 'pid' => $row['pid'], 'price' => $row['saleprice']]);
            if($terminate_limit-- <= 0) break;
          }
        }
      }
      ModelConsole::Commit();
    } catch(Exception $e) {
      ModelConsole::RollBack();
      throw $e;
    }
  }

  /**
   * @console
   */
  public function collect(){
    try {
      $this->collect_under();
      fwrite(STDOUT, "'under' list was collected successfully\r\n");
    } catch(Exception $e) {
      fwrite(STDOUT, $e->getMessage());
    }
    try {
      $this->collect_specials();
      fwrite(STDOUT, "'specials' list was collected successfully\r\n");
    } catch(Exception $e) {
      fwrite(STDOUT, $e->getMessage());
    }
    try {
      $this->collect_bestsellers();
      fwrite(STDOUT, "'bestsellers' list was collected successfully\r\n");
    } catch(Exception $e) {
      fwrite(STDOUT, $e->getMessage());
    }
  }

}
