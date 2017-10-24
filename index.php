<?php
$working_directory = __DIR__;
$sapi_type = php_sapi_name();
if(substr($sapi_type, 0, 3) == 'cli') {
  include('console/core/core.php');
} else {
  include('core/core.php');
}
_A_::start();
