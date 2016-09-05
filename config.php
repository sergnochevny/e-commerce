<?php
session_start();
define ('DS', '/');
$sitePath = str_replace(DIRECTORY_SEPARATOR, DS, realpath(dirname(__FILE__) . DS) . DS);
define ('SITE_PATH', $sitePath); 
ini_set('display_errors','On');

//    $db = mysql_connect ("localhost","root","JzpEk0659o");
//    mysql_select_db ("steph03_iluvfabrix",$db);
ini_set('mysql.connect_timeout', 60);
$db = mysql_connect ("localhost","root","");
mysql_select_db ("iluvfabrix",$db);

setlocale(LC_ALL,'en_US');
