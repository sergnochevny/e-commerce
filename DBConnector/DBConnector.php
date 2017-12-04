<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 30/11/17
 * Time: 11:55 AM
 */

interface DBConnector
{
  public function initConnection($dbname);
}